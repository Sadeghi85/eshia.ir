
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
		
		var teachers = {{ json_encode($teacherArray) }}

		$("#lessons").select2({
		  data: lessons,
		  dir: "rtl"
		})
		
		$("#teachers").select2({
		  data: null,
		  dir: "rtl"
		})
		
		$("#lessons").on("select2:select", function (e) {
			if (e)
			{
				var key = e.params.data.id;
				//var obj = teachers[key]
				//var data = [];
				//for (elem in obj) {
				//   data.push(obj[elem])
				//}
				//var data = $.map(teachers[key], function(el) { return el });
				var data = teachers[key];
				//console.log(teachers[key])
				//$("#teachers").select2('data', null)
				$("#teachers").select2().empty().trigger("change");
				$("#teachers").select2({
				  data: data,
				  dir: "rtl"
				}).trigger("change");
				//$("#teachers").trigger('change.select2');
			}
		});
	</script>

	

@stop


@section('content')
<div id="contents">

	<div style="margin:10px 10px;">
		<select id="lessons" style="width:300px;"></select>
	</div>
	
	<div style="margin:10px 10px;">
		<select id="teachers" style="width:300px;"></select>
	</div>
	
	<!-- <div id="lessons" style="width:300px;margin-top:10px;">
		<multiselect v-model="value" selected-label="" select-label="" deselect-label="" track-by="name" label="value" placeholder="" :close-on-select="true" :options="options" :searchable="true" :allow-empty="true" @select="onSelect"><span slot="noResult">نتیجه&zwnj;ای یافت نشد</span></multiselect>
		<pre class="language-json"><code>@{{ value.value  }}</code></pre>
	</div>

	<div id="teachers" style="width:300px;margin-top:10px;">
		<multiselect v-model="value" selected-label="" select-label="" deselect-label="" track-by="name" label="value" placeholder="" :close-on-select="true" :options="options" :searchable="true" :allow-empty="true" ><span slot="noResult">نتیجه&zwnj;ای یافت نشد</span></multiselect>
		<pre class="language-json"><code>@{{ value.value  }}</code></pre>
	</div>
-->


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
									<tr>
										<td class="tdLabel">&nbsp;</td>
										<td class="tdInput">
											<select name="groupKey">
												@foreach ($groupArray as $groupKey => $groupName)
													<option value="{{ $groupKey }}">{{ $groupName }}</option>
												@endforeach
											</select>
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