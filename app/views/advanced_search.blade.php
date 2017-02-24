
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