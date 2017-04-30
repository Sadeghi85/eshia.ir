@section('content')
<div class="searchcontent">
	<div class="searchcounter">
		<div class="pagenave">
			{{ $results->links() }}
		</div>
		<div class="counter">
			<span class="result_count">{{ $totalCount }}</span>&nbsp;&nbsp;@lang('app.query_search_result')&nbsp;&nbsp;({{ sprintf('%01.2f', $time) }}&nbsp;&nbsp;@lang('app.search_seconds'))
		</div>


	</div>
		@if (Input::get('lessonKey', ''))
		<div class="searchagain">
			<span>{{ sprintf(trans('app.search_form_again_info'), '<font color="#ff6c13">', '</font>', $lessonName, '<font color="#ff6c13">', '</font>', $teacherName, '<font color="#ff6c13">', '</font>', $yearName) }}</span>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<form  class="resform" style="display:inline;" method="post" action="{{ action('SearchController@processAdvancedPage') }}">
				<input type="submit" value="" id="searchButton" class="SearchKey" style="position: relative;top:4px;left:0px;margin-right:-5px;background-color: aliceblue;border-radius:3px;" />
				<input type="text" name="and" value="{{{ $query }}}" style="font-family:eshiatrad_ttf, eshiatrad;width:195px;vertical-align:middle;height:12px;font-size:12pt;margin-top:5px; background:#e4f0fa;border-radius:3;margin-bottom:2px;margin-left: 5px" />
				
				<input type="hidden" name="lessonKey" value="{{ Input::get('lessonKey', '') }}" />
				<input type="hidden" name="teacherKey" value="{{ Input::get('teacherKey', '') }}" />
				<input type="hidden" name="yearKey" value="{{ Input::get('yearKey', '') }}" />
			</form>
		</div>
		@endif
	
	<!--------------------------- result-->
	<div>
		@foreach ($results as $key => $result)
			<div class="result">
				<div class="boxeadad">
					<span class="adadjadid">{{ $perPage * ($page - 1) + $key +1 }}</span>
				</div>
				<div class="searchlink">
					<a href="{{ Helpers::to(sprintf('/Feqh/Archive/text/%s/%s/%s/%s/%s', $result['attrs']['teacher'], $result['attrs']['lesson'], $result['attrs']['year'], $result['attrs']['date'], urlencode($query))) }}" title="">
						@if (strlen($result['attrs']['date']) == 6)
							{{ sprintf(trans('app.search_info_date'), '<font color="#ff6c13">', '</font>', $result['attrs']['represented_lesson'], '<font color="#ff6c13">', '</font>', $result['attrs']['represented_teacher'], '<font color="#ff6c13">', '</font>', $result['attrs']['represented_date']) }}
						@else
							{{ sprintf(trans('app.search_info_session'), '<font color="#ff6c13">', '</font>', $result['attrs']['represented_lesson'], '<font color="#ff6c13">', '</font>', $result['attrs']['represented_teacher'], '<font color="#ff6c13">', '</font>', $result['attrs']['represented_date']) }}
						@endif
					</a>
				</div>
				<div class="resulttext">
					{{ $result['attrs']['excerpt'] }}
				</div>
			</div>
		@endforeach
	</div>
	<!--------------------------- result END-->

	<div class="searchcounter">
		<div class="pagenave">
			{{ $results->links() }}
		</div>
		<div class="counter">
			<span class="result_count">{{ $totalCount }}</span>&nbsp;&nbsp;@lang('app.query_search_result')&nbsp;&nbsp;({{ sprintf('%01.2f', $time) }}&nbsp;&nbsp;@lang('app.search_seconds'))
		</div>
	</div>
</div>
@stop