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

	<!--------------------------- result-->
	<div>
		@foreach ($results as $key => $result)
			<div class="result">
				<div class="boxeadad">
					<span class="adadjadid">{{ $perPage * ($page - 1) + $key +1 }}</span>
				</div>
				<div class="searchlink">
					<a href="{{ Helpers::to(sprintf('/Feqh/Archive/text/%s/%s/%s/%s/%s', $result['attrs']['teacher'], $result['attrs']['lesson'], $result['attrs']['year'], $result['attrs']['date'], $query)) }}" title="">
						@if (strlen($result['attrs']['date']) == 6)
							{{ sprintf(trans('app.search_info_date'), '<font color="#ff6c13">', '</font>', $result['attrs']['represented_teacher'], '<font color="#ff6c13">', '</font>', $result['attrs']['represented_lesson'], '<font color="#ff6c13">', '</font>', $result['attrs']['represented_date']) }}
						@else
							{{ sprintf(trans('app.search_info_session'), '<font color="#ff6c13">', '</font>', $result['attrs']['represented_teacher'], '<font color="#ff6c13">', '</font>', $result['attrs']['represented_lesson'], '<font color="#ff6c13">', '</font>', $result['attrs']['represented_date']) }}
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