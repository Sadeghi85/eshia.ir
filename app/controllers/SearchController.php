<?php

class SearchController extends BaseController {

	
	public function index($teacher, $course, $year)
	{
		$teacher = strtolower($teacher);
		$course = strtolower($course);
		$year = (string)($year);
		$query = Input::get('q');
		
		$query = preg_replace('#\p{Cf}+#u', ' ', str_replace(pack('H*', 'c2a0'), '', $query));
		
		$page = Input::get('page', 1);
		$perPage = Config::get('app_settings.results_per_page', 10);  //number of results per page
		
		$sphinx = new \Sphinx\SphinxClient;
		
		$sphinx->setServer('127.0.0.1', 9312);
		
		$sphinx->resetFilters();
		
		$sphinx->setMatchMode(\Sphinx\SphinxClient::SPH_MATCH_EXTENDED);
		//$sphinx->setRankingMode(\Sphinx\SphinxClient::SPH_RANK_PROXIMITY_BM25);
		$sphinx->setRankingMode(\Sphinx\SphinxClient::SPH_RANK_EXPR, 'sum((lcs*(1+exact_order+(1/(1+min_gaps))*(word_count>1))+wlccs)*user_weight)*1000+bm25');
		$sphinx->setSortMode(\Sphinx\SphinxClient::SPH_SORT_EXTENDED, '@relevance DESC, modified_at ASC, @id ASC');
		
		$sphinx
		->setFilter('teacher_hash', array(sprintf('%u', crc32($teacher))))
		->setFilter('course_hash', array(sprintf('%u', crc32($course))))
		->setFilter('year_hash', array(sprintf('%u', crc32($year))));
		
		$sphinx->setLimits(($page - 1) * $perPage, $perPage, Config::get('app_settings.search_result_limit', 1000));
		
		$sphinx->setMaxQueryTime(Config::get('app_settings.search_timeout_limit', 3000)); // in mili-seconds
		
		$sphinx->setArrayResult(true);
		
		$results = $sphinx->query($query, Config::get('app_settings.search_index_name', 'www_eshia_ir_main'));
		
		if (isset($results['matches']))
		{
			$thisPage = $results['matches'];
			
			$docs = array();
			foreach ($thisPage as $_page)
			{
				$docs[] = $_page['attrs']['path'];
			}
			
			$excerpts = $sphinx->buildExcerpts($docs, Config::get('app_settings.search_index_main_name', 'www_eshia_ir_main'), $query,
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

			for ($i = count($thisPage) - 1; $i >= 0; --$i)
			{
				$excerpts[$i] = preg_replace('#[[:space:]]+#', ' ',
									preg_replace('#\p{Cf}+#u', pack('H*', 'e2808c'),
										str_replace(pack('H*', 'c2a0'), '',
											str_replace(pack('H*', 'efbbbf'), '',
												iconv('UTF-8', 'UTF-8//IGNORE',
													$excerpts[$i]
												)
											)
										)
									)
								);
				
				//$thisPage[$i]['attrs']['date']
				$thisPage[$i]['attrs']['excerpt'] = $excerpts[$i];
			}

			$paginator = Paginator::make($thisPage, min($results['total'], Config::get('app_settings.search_result_limit', 1000)), $perPage);
			return View::make('search-result')->with(array('results' => $paginator, 'time' => $results['time'], 'totalCount' => $results['total_found'], 'resultCount' => $results['total'], 'page' => $page, 'perPage' => $perPage, 'query' => urlencode($query), 'teacher' => $teacher, 'course' => $course, 'year' => $year));
		}
		
		if ($page > 1)
		{
			return Redirect::to(sprintf('/search/%s/%s/%s?q=', $teacher, $course, $year).str_replace(array(' ', '%20'), '_', $query));
		}
		
		if (isset($results['warning']) and $results['warning'] == 'query time exceeded max_query_time')
		{
			Helpers::setExceptionErrorMessage(Lang::get('app.query_timed_out'));
		}
		else
		{
			Helpers::setExceptionErrorMessage(Lang::get('app.query_search_result_not_found', array('query' => sprintf('"%s"', $query))));
		}
		
		App::abort('404');
	}
	
}
