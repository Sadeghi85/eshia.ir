
@section('meta')
	<meta name="viewport" content="width=device-width, initial-scale=0.5, maximum-scale=0.5, user-scalable=0" />
@stop

@section('style')
	@parent
	
	<link href="/assets/css/select2.min.css" rel="stylesheet" type="text/css"/>
	
	<style type="text/css">
		
	</style>
	
@stop

@section('javascript')
	@parent
	
	<script src="/assets/js/jquery-1.10.2.min.js"></script>
	<script src="/assets/js/select2.full.min.js"></script>
	
	<script type="text/javascript">
		var lessons = {{ json_encode($lessonArray) }};
		var teachers = {{ json_encode($teacherArray) }};
		var years = {{ json_encode($yearArray) }};

		$('#lessonKey').select2({
			//minimumResultsForSearch: -1,
			data: lessons,
			dir: 'rtl'
		})
		
		$('#teacherKey').select2({
			//minimumResultsForSearch: -1,
			data: null,
			dir: 'rtl'
		})
		
		$('#yearKey').select2({
			//minimumResultsForSearch: -1,
			data: null,
			dir: 'rtl'
		})
		
		$('#lessonKey').on('select2:select', function (e) {
			if (e)
			{
				var key = e.params.data.id;
				var data = teachers[key];
				$('#teacherKey').select2().empty().trigger('change');
				$('#teacherKey').select2({
					//minimumResultsForSearch: -1,
					data: data,
					dir: 'rtl'
				}).trigger('change');
				
				$('#yearKey').select2().empty().trigger('change');
			}
		});
		
		$('#teacherKey').on('select2:select', function (e) {
			if (e)
			{
				var key = e.params.data.id;
				var data = years[key];
				$('#yearKey').select2().empty().trigger('change');
				$('#yearKey').select2({
					//minimumResultsForSearch: -1,
					data: data,
					dir: 'rtl'
				}).trigger('change');
			}
		});
		
		
	</script>

	

@stop


@section('content')
<div id="contents">

	


	<div id="contents_cover" class="Page_advancedSearch">
		<table id="advancedsearch">
			<tbody>
				<tr>
					<td>
						<form name="frmQuery" method="post">
							<span class="tdLabel">&nbsp;</span>
							<table id="advanced" cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
										<td class="tdLabel">@lang('app.search_find_items_that')</td>
										<td class="tdInput"></td>
									</tr>
									<tr>
										<td class="tdLabel">@lang('app.search_all_these_words')</td>
										<td class="tdInput"><input name="and" type="text" value=""></td>
									</tr>
									<tr>
										<td class="tdLabel">@lang('app.search_this_phrase')</td>
										<td class="tdInput"><input name="phrase" type="text" value=""></td>
									</tr>
									<tr>
										<td class="tdLabel">@lang('app.search_any_these_words')</td>
										<td class="tdInput"><input name="or" type="text" value=""></td>
									</tr>
								</tbody>
							</table>
							<span class="tdLabel">@lang('app.search_but')</span>
							<table cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
										<td class="tdLabel">@lang('app.search_not_these_words')</td>
										<td class="tdInput"><input name="not" type="text" value=""></td>
									</tr>
								</tbody>
							</table>

							<span class="tdLabel">@lang('app.search_where')</span>
							<table cellspacing="0" cellpadding="0">
								<tbody>
									{{--<tr>
										<td class="tdLabel">&nbsp;</td>
										<td class="tdInput">
											<select name="groupKey">
												@foreach ($groupArray as $groupKey => $groupName)
													<option value="{{ $groupKey }}">{{ $groupName }}</option>
												@endforeach
											</select>
										</td>
									</tr>--}}
									
									<tr>
										<td class="tdLabel">@lang('app.lesson')</td>
										<td class="tdInput">
											<div style="margin:10px 10px;">
												<select name="lessonKey" id="lessonKey" style="width:300px;"></select>
											</div>
										</td>
									</tr>
									<tr>
										<td class="tdLabel">@lang('app.teacher')</td>
										<td class="tdInput">
											<div style="margin:10px 10px;">
												<select name="teacherKey" id="teacherKey" style="width:300px;"></select>
											</div>
										</td>
									</tr>
									<tr>
										<td class="tdLabel">@lang('app.year')</td>
										<td class="tdInput">
											<div style="margin:10px 10px;">
												<select name="yearKey"id="yearKey" style="width:300px;"></select>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
							<div align="center" style="margin: 0.5em 2em"><input type="submit" value="@lang('app.search_search')"></div>
						</form>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
@stop

@section('title')
	@parent
@stop