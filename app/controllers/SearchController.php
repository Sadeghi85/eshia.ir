<?php

class SearchController extends BaseController {

	protected $layout;
	
	public function __construct()
	{
		$this->layout = 'layouts.master';
    }
	
	public function showPage($ar, $query = '', $teacher = '', $lesson = '', $year = '')
	{
		if (strtolower($ar) != 'ar') {
			if ($lesson) {
				$temp = $lesson;
				$year = $teacher;
				$lesson = $query;
				$teacher = $ar;
				$query = $temp;
			}
			else {
				$query = $ar;
			}
		}
		else {
			if ($year) {
				$temp = $year;
				$year = $lesson;
				$lesson = $teacher;
				$teacher = $query;
				$query = $temp;
			}
		}
		
		$query = preg_replace('#\p{Cf}+#u', ' ', str_replace(pack('H*', 'c2a0'), ' ', $query));
		
		$page = Input::get('page', 1);
		$perPage = Config::get('app_settings.results_per_page', 10);  //number of results per page
		
		$sphinx = new \Sphinx\SphinxClient;
		
		$sphinx->setServer('127.0.0.1', 9312);
		
		$sphinx->resetFilters();
		
		$sphinx->setRankingMode(SPH_RANK_EXPR, 'sum((lcs*(1+exact_order+(1/(1+min_gaps))*(word_count>1))+wlccs)*user_weight)*1000+bm25');
		$sphinx->setSortMode(SPH_SORT_EXTENDED, '@weight DESC, modified_at ASC, @id ASC');
		
		$preferredTeachersArray = Helpers::getPreferredTeachersArray();
		if ( ! empty($preferredTeachersArray)) {
			$preferredTeachers = implode(',', $preferredTeachersArray);
			$sphinx->setSortMode(
				SPH_SORT_EXPR,
				sprintf('IF(IN(teacher_hash,%s),@weight+1,@weight/(@weight+1))', $preferredTeachers)
			);
		}
		
		//$groupKey = Input::get('groupKey', '');
		//$groupArray = $groupKey ? unserialize(Crypt::decrypt(urldecode($groupKey))) : null;
		
		// if ($groupArray)
		// {
			// !empty($groupArray['teachers']) ? $sphinx->setFilter('teacher_hash', $groupArray['teachers']) : '';
			// !empty($groupArray['lessons']) ? $sphinx->setFilter('lesson_hash', $groupArray['lessons']) : '';
			// !empty($groupArray['years']) ? $sphinx->setFilter('year_hash', $groupArray['years']) : '';
		// }
		
		$lessonKey = Input::get('lessonKey', '');
		$teacherKey = Input::get('teacherKey', '');
		$yearKey = Input::get('yearKey', '');
		
		$lessonArray = $lessonKey ? unserialize(Crypt::decrypt(urldecode($lessonKey))) : null;
		$teacherArray = $teacherKey ? unserialize(Crypt::decrypt(urldecode($teacherKey))) : null;
		$yearArray = $yearKey ? unserialize(Crypt::decrypt(urldecode($yearKey))) : null;
		//dd($teacherArray);
		Helpers::prepareSearchFilters($lessonArray, $teacherArray, $yearArray);
		//dd($teacherArray);
		if ($lessonArray)
		{
			$sphinx->setFilter('lesson_hash', $lessonArray);
		}
		
		if ($teacherArray)
		{
			$sphinx->setFilter('teacher_hash', $teacherArray);
		}
		
		if ($yearArray)
		{
			$sphinx->setFilter('year_hash', $yearArray);
		}
		
		if ($teacher and $lesson and $year) {
			$sphinx->setFilter('teacher_hash', [Helpers::getStringToUintHash($teacher)]);
			$sphinx->setFilter('lesson_hash', [Helpers::getStringToUintHash($lesson)]);
			$sphinx->setFilter('year_hash', [Helpers::getStringToUintHash($year)]);
		}
		
		$sphinx->setLimits(($page - 1) * $perPage, $perPage, Config::get('app_settings.search_result_limit', 1000));
		
		$sphinx->setMaxQueryTime(Config::get('app_settings.search_timeout_limit', 3000)); // in mili-seconds
		
		$sphinx->setArrayResult(true);
		
		$results = $sphinx->query($query, Config::get('app_settings.search_index_name', 'www_eshia_ir_main'));
		
		if (isset($results['matches'])) {
			$thisPage = $results['matches'];
			
			$docs = array();
			foreach ($thisPage as $_page) {
				$docs[] = $_page['attrs']['path'];
			}
			
			$excerpts = $sphinx->buildExcerpts($docs, Config::get('app_settings.search_index_main_name', 'lib_eshia_ir_main'), $query,
							array
							(
								'query_mode' => true,
								'exact_phrase' => true,
								'weight_order' => false,
								'load_files' => true,
								'allow_empty' => false,
								'before_match' => '<span class="hilight">',
								'after_match' => '</span>'
							));

			for ($i = count($thisPage) - 1; $i >= 0; --$i) {
				$_utf8Content = @iconv('UTF-8', 'UTF-8//IGNORE', $excerpts[$i]);
				If ( ! $_utf8Content) {
					Log::error(sprintf('Detected an incomplete multibyte character in file "%s".', $thisPage[$i]['attrs']['path']));
					Helpers::setExceptionErrorMessage(Lang::get('app.page_display_error'));
					
					App::abort('404');
				}
				
				$excerpts[$i] = preg_replace('#[[:space:]]+#u', ' ',
									preg_replace('#\p{Cf}+#u', pack('H*', 'e2808c'),
										str_replace([pack('H*', 'c2a0'), '&#160;'], ' ',
											str_replace([pack('H*', 'efbbbf'), '&#65279;'], ' ',
												str_replace(pack('H*', '00'), '',
													$_utf8Content
												)
											)
										)
									)
								);
						
				$thisPage[$i]['attrs']['excerpt'] = $excerpts[$i];
				
				$thisPage[$i]['attrs']['represented_teacher'] = str_replace(['teachers.', '.name'], '', trans(sprintf('teachers.%s.name', $thisPage[$i]['attrs']['teacher'])));
				$thisPage[$i]['attrs']['represented_lesson']  = preg_replace('#^(?:[^\.]+\.)+(.+)$#', '$1', trans(sprintf('lessons.%s', $thisPage[$i]['attrs']['lesson'])));
				$date = $thisPage[$i]['attrs']['date'];
				
				if (strlen($date) == 6) {
					$date = sprintf('%s%s/%s%s/%s%s', $date[0], $date[1], $date[2], $date[3], $date[4], $date[5]);
				} else {
					$date = sprintf('%s', (int) $date);
				}
				
				$thisPage[$i]['attrs']['represented_date'] = $date;
			}

			$paginator = Paginator::make($thisPage, min($results['total'], Config::get('app_settings.search_result_limit', 1000)), $perPage);
			
			$content = View::make('search')->with( [
				'results' => $paginator, 'time' => $results['time'], 'totalCount' => $results['total_found'], 'resultCount' => $results['total'], 'page' => $page, 'perPage' => $perPage, 'query' => urlencode($query)
			] );
			
			$this->layout->content = $content;
			return;
		}
		
		if ($page > 1) {
			return Helpers::redirect(sprintf('/search/%s', $query));
		}
		
		if (isset($results['warning']) and $results['warning'] == 'query time exceeded max_query_time') {
			Helpers::setExceptionErrorMessage(Lang::get('app.query_timed_out'));
		}
		else {
			Helpers::setExceptionErrorMessage(Lang::get('app.query_search_result_not_found', array('query' => sprintf('"%s"', $query))));
		}
		
		App::abort('404');
	}
	
	public function showAdvancedPage()
	{
		// # return View::make('advanced_search')->with('groupArray', $groupArray);
		$this->layout->content = View::make('advanced_search');
		return;
	}
	
	public function processAdvancedPage()
	{
		$lessonKey = Input::get('lessonKey', '');
		$teacherKey = Input::get('teacherKey', '');
		$yearKey = Input::get('yearKey', '');
		
		if ($lessonKey == base64_encode(Lang::get('app.all'))) { $lessonKey = ''; }
		if ($teacherKey == base64_encode(Lang::get('app.all'))) { $teacherKey = ''; }
		if ($yearKey == base64_encode(Lang::get('app.all'))) { $yearKey = ''; }
		
		$and = Input::get('and', '');
		$and = trim(preg_replace('#[[:space:]]+#u', ' ', $and));
		
		$or = Input::get('or', '');
		$or = trim(preg_replace('#[[:space:]]+#u', ' ', $or));
		if ($or) { $or = sprintf('(%s)', preg_replace('# #', ' | ', $or)); }
		
		$not = Input::get('not', '');
		$not = trim(preg_replace('#[[:space:]]+#u', ' ', $not));
		if ($not) { $not = preg_replace('#(?:^|(?<= ))([^[:space:]]+)#u', '!$1', $not); }
		
		$phrase = Input::get('phrase', '');
		if ($phrase) { $phrase = sprintf('"%s"', trim(preg_replace('#[[:space:]]+#u', ' ', $phrase))); }
		
		$query = trim(preg_replace('#[[:space:]]+#u', ' ', sprintf('%s %s %s %s', $phrase, $or, $not, $and)));
		
		if (App::getLocale() == 'ar') {
			return Helpers::redirect(sprintf('/ar/search/%s?lessonKey=%s&teacherKey=%s&yearKey=%s', urlencode($query), urlencode($lessonKey), urlencode($teacherKey), urlencode($yearKey)));
		}
		else {
			return Helpers::redirect(sprintf('/search/%s?lessonKey=%s&teacherKey=%s&yearKey=%s', urlencode($query), urlencode($lessonKey), urlencode($teacherKey), urlencode($yearKey)));
		}
		
	}
	
	public function getSearchData()
	{
		$control = Input::get('control', '');
		
		if ( ! $control)
			return;
		
		$name = App::getLocale() == 'fa' ? 'name' : 'arname';
		
		$xmlContent = file_get_contents(base_path() . '\\App_Data\\Lessons.xml');
		
		$xml = new DomDocument;
		
		try	{
			$xml->loadXML($xmlContent, LIBXML_NOBLANKS);
		}
		catch (\Exception $e) {
			Log::error('Error loading Lessons.xml. ( '. __FILE__ .' on line '. __LINE__ .' )');
			Helpers::setExceptionErrorMessage(Lang::get('app.page_display_error'));
			
			App::abort(500);
		}
		
		$xpath = new DOMXpath($xml);
		
		switch ($control)
		{
			case 'lessonKey':
				$xpathQuery = sprintf('//%s[not(@%s) or @%s != \'%s\']', 'group', 'hide', 'hide', '1');
				$groupNode = $xpath->query($xpathQuery, $xml);
				$groupArray = [];
				$lessonArray = [];
				
				foreach ($groupNode as $group)
				{
					$xpathQuery = sprintf('./%s', 'lesson');
					$lessonNode = $xpath->query($xpathQuery, $group);
					
					$groupKeyEncrypted = Crypt::encrypt(serialize(['group'=>$group->getAttribute('key'),'lesson'=>null]));
					$lessonArray[] = [
						'id' => $groupKeyEncrypted,
						'text' => $group->getAttribute($name),
						'desc' => sprintf('<span style="padding: 0 0 0 0;"><b>%s%s</b></span>', $group->getAttribute($name), pack('H*', 'e2808f')),
						//'group' => $group->getAttribute($name).pack('H*', 'e2808f'),
					];
					
					foreach ($lessonNode as $lesson)
					{
						$lessonKeyEncrypted = Crypt::encrypt(serialize(['group'=>$group->getAttribute('key'),'lesson'=>$lesson->getAttribute('key')]));
						
						$lessonArray[] = [
							'id' => $lessonKeyEncrypted,
							'text' => $lesson->getAttribute($name),
							'desc' => sprintf('<span style="padding: 0 15px 0 0;">%s%s</span>', $lesson->getAttribute($name), pack('H*', 'e2808f')),
							//'group' => $group->getAttribute($name).pack('H*', 'e2808f'),
						];
					}
				}
				
				return json_encode($lessonArray);
				
				break;
				
			case 'teacherKey':
				$key = Input::get('id', '');
				$key = unserialize(Crypt::decrypt(urldecode($key)));
				$teacherArray = [];
				
				if ($key['lesson'])
				{
					$xpathQuery = sprintf('//%s[(not(@%s) or @%s != \'%s\') and (@%s=\'%s\')]/%s[@%s=\'%s\']/%s', 'group', 'hide', 'hide', '1', 'key', $key['group'], 'lesson', 'key', $key['lesson'], 'teacher');
				}
				else
				{
					$xpathQuery = sprintf('//%s[(not(@%s) or @%s != \'%s\') and (@%s=\'%s\')]/%s/%s', 'group', 'hide', 'hide', '1', 'key', $key['group'], 'lesson', 'teacher');
				}
				
				$teacherNode = $xpath->query($xpathQuery, $xml);
				
				foreach ($teacherNode as $teacher)
				{
					$teacherKeyEncrypted = Crypt::encrypt(serialize(['group'=>$key['group'],'lesson'=>$key['lesson'],'teacher'=>$teacher->getAttribute('key')]));
					
					$teacherArray[] = [
						'id' => $teacherKeyEncrypted,
						'text' => $teacher->getAttribute($name),
						'desc' => $teacher->getAttribute($name).pack('H*', 'e2808f'),
					];
				}
				
				return json_encode($teacherArray);
				
				break;
				
			case 'yearKey':
				$key = Input::get('id', '');
				$key = unserialize(Crypt::decrypt(urldecode($key)));
				$yearArray = [];
				
				if ($key['lesson'])
				{
					$xpathQuery = sprintf('//%s[(not(@%s) or @%s != \'%s\') and (@%s=\'%s\')]/%s[@%s=\'%s\']/%s[@%s=\'%s\']/%s', 'group', 'hide', 'hide', '1', 'key', $key['group'], 'lesson', 'key', $key['lesson'], 'teacher', 'key', $key['teacher'], 'year');
				}
				else
				{
					$xpathQuery = sprintf('//%s[(not(@%s) or @%s != \'%s\') and (@%s=\'%s\')]/%s/%s[@%s=\'%s\']/%s', 'group', 'hide', 'hide', '1', 'key', $key['group'], 'lesson', 'teacher', 'key', $key['teacher'], 'year');
				}
				
				$yearNode = $xpath->query($xpathQuery, $xml);

				foreach ($yearNode as $year)
				{
					$yearKeyEncrypted = Crypt::encrypt(serialize(['group'=>$key['group'],'lesson'=>$key['lesson'],'teacher'=>$key['teacher'],'year'=>$year->getAttribute('key')]));
					
					$yearArray[] = [
						'id' => $yearKeyEncrypted,
						'text' => $year->getAttribute('key'),
						'desc' => $year->getAttribute('key'),
					];
				}
				
				return json_encode($yearArray);
				
				break;
			default:
				return;
			
		}
		
	}
	
}
