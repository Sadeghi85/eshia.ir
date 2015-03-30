@extends('layout.default')


@section('content')
<div style="width: 100%; padding: 10px;">

	<div class="linkbox">
		<div class="linkboxheader">
		
			<table style="width: 100%;" class="pageSelectorPanel">
						<tr>
							<td style="float: right;" class="pg-Left"><span class="result_count">{{ $totalCount }}</span>&nbsp;&nbsp;@lang('app.query_search_result')&nbsp;&nbsp;({{ sprintf('%01.2f', $time) }}&nbsp;&nbsp;@lang('app.search_seconds'))</td>
                            <td style="float: left;" class="pg-right">{{ $results->links() }}</td>
						</tr>
					</table>
		
		</div>
		
		<ul>
			<table>
			@foreach ($results as $key => $result)
			<li>
				<tr>
				<td class="id">{{ $perPage * ($page - 1) + $key +1 }}</td>
				<td class="data">
					<div class="result">
					<a href="">&nbsp;</a>
					<a href="{{-- Helpers::to(sprintf('/%s/%s/%s/%s', (int) $result['attrs']['bookid'], (int) $result['attrs']['volume'], (int) $result['attrs']['page'], $query)) --}}" title="">{{ sprintf(trans('app.search_info'), '<font color="#ff6c13">', '</font>', $result['attrs']['teacher'], '<font color="#ff6c13">', '</font>', $result['attrs']['course'], '<font color="#ff6c13">', '</font>', $result['attrs']['date']) }}</a>
					{{-- <\?= anchor($item['address'].'/'.$term, $item['label'], array('title' => '')) ?> --}}
					</div>
				<div class="preview">{{ $result['attrs']['excerpt'] }}</div>
				</td>
				</tr>
			</li>
			@endforeach
			</table>
		</ul>
	</div>







</div>
@stop