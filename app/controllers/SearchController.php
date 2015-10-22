<?php

class SearchController extends BaseController {

	protected $layout;
	
	public function __construct()
	{
		$this->layout = 'layouts.master';
    }
	
	public function showPage($ar, $query = '', $teacher = '', $course = '', $year = '')
	{
		if (strtolower($ar) != 'ar') {
			if ($course) {
				$temp = $course;
				$year = $teacher;
				$course = $query;
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
				$year = $course;
				$course = $teacher;
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
		
		if ($teacher and $course and $year) {
			$sphinx->setFilter('teacher_hash', [Helpers::getStringToUintHash($teacher)]);
			$sphinx->setFilter('course_hash', [Helpers::getStringToUintHash($course)]);
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
				$thisPage[$i]['attrs']['represented_course']  = preg_replace('#^(?:[^\.]+\.)+(.+)$#', '$1', trans(sprintf('courses.%s', $thisPage[$i]['attrs']['course'])));
				$date = $thisPage[$i]['attrs']['date'];
				$date = sprintf('%s/%s/%s', $date[0].$date[1], $date[2].$date[3], $date[4].$date[5]);
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
	
	
	
}
