
@section('meta')
	<!--<meta name="viewport" content="width=device-width, initial-scale=0.5, maximum-scale=0.5, user-scalable=0" />-->
@stop

@section('style')
	@parent
	
	<link href="/assets/jquery-easyui-1.5.1/themes/metro/easyui.css" rel="stylesheet" media="screen" />
	<link href="/assets/jquery-easyui-rtl/easyui-rtl.css" rel="stylesheet" media="screen" />
	
	<style type="text/css">
		.combobox-item, .combobox-group, .combobox-stick {
			font-size: 16px;
			font-family: Tahoma;
		}
		
		.textbox .textbox-text {
			font-size: 16px;
			font-family: Tahoma;
		}
		
		.textbox  {
			border: 1px solid #cacaca !important;
			-webkit-border-radius: 5px !important;
			-moz-border-radius: 5px !important;
		}
		
		.textbox:hover {
			border: 1px solid #6295f3 !important;
			-webkit-border-radius: 5px !important;
			-moz-border-radius: 5px !important;
		}
		
		.panel-body {
			font-size: 16px;
		}
		
		.combo-arrow-hover {
		  background-color: #cce6ff !important;
		}
		.combo-arrow:hover {
		  background-color: #cce6ff !important;
		}

	</style>
	
@stop

@section('javascript')
	@parent
	
	<script src="/assets/jquery-easyui-1.5.1/jquery.min.js" type="text/javascript"></script>
	<script src="/assets/jquery-easyui-1.5.1/jquery.easyui.min.js" type="text/javascript"></script>
	<script src="/assets/jquery-easyui-rtl/easyui-rtl.js" type="text/javascript"></script>
	
	<script type="text/javascript">
	$('#lessonKey').combobox({
		url: '{{ action('SearchController@getSearchData') }}',
		method: 'get',
		queryParams: { 'control': 'lessonKey' },
		valueField:'id',
		textField:'text',
		groupField:'group',
		groupPosition:'sticky',
		height:'28',
		label: '',
		labelPosition: 'top',
		panelHeight:'400px',
		hasDownArrow: true,
		mode: 'local',
		formatter: formatItem,
		
		onSelect: function(s){
            var url = '{{ action('SearchController@getSearchData') }}?id='+s.id;
            $('#teacherKey').combobox('reload', url);
			$('#teacherKey').combobox('clear');
			$('#yearKey').combobox('reload', '');
			$('#yearKey').combobox('clear');
        }
	});
	
	$('#teacherKey').combobox({
		url: '',
		method: 'get',
		queryParams: { 'control': 'teacherKey' },
		valueField:'id',
		textField:'text',
		groupField:'group',
		groupPosition:'sticky',
		height:'28',
		label: '',
		labelPosition: 'top',
		panelHeight:'400px',
		hasDownArrow: true,
		mode: 'local',
		formatter: formatItem,
		
		onSelect: function(s){
            var url = '{{ action('SearchController@getSearchData') }}?id='+s.id;
            $('#yearKey').combobox('reload', url);
			$('#yearKey').combobox('clear');
        }
	});
	
	$('#yearKey').combobox({
		url: '',
		method: 'get',
		queryParams: { 'control': 'yearKey' },
		valueField:'id',
		textField:'text',
		groupField:'group',
		groupPosition:'sticky',
		height:'28',
		label: '',
		labelPosition: 'top',
		panelHeight:'400px',
		hasDownArrow: true,
		mode: 'local',
		formatter: formatItem,
		
	});
	
	function formatItem(row){
		var s = row.desc;
		return s;
	}
	</script>
@stop

@section('content')
<div id="contents">
	<div id="contents_cover" class="Page_advancedSearch">
	
	    <div style="margin:35px 0 10px 0;"></div>
		<div class="easyui-accordion" style="width:100%;height:600px;">
			<div title="جستجو نوع 1" style="overflow:auto;padding:10px;">
				<table id="advancedsearch">
			<tbody>
				<tr>
					<td>
						<form name="frmQuery" method="post">
							
							<table id="advanced" cellspacing="0" cellpadding="0">
								<tbody>
									
									<tr>
										<td class="tdLabel">عبارت</td>
										<td class="tdInput">
											<div style="margin:10px 10px;">
												<input style="width: 490px;" name="and" type="text" value="">
											</div>
										</td>
									</tr>
									
								</tbody>
							</table>

							<table cellspacing="0" cellpadding="0">
								<tbody>
									<tr>
										<td class="tdLabel">@lang('app.lesson')</td>
										<td class="tdInput">
											<div style="margin:10px 10px;">
												<input id="lessonKey" class="easyui-combobox" name="lessonKey" style="width:500px;">
												
											</div>
										</td>
									</tr>
									<tr>
										<td class="tdLabel">@lang('app.teacher')</td>
										<td class="tdInput">
											<div style="margin:10px 10px;">
												<input id="teacherKey" class="easyui-combobox" name="teacherKey" style="width:500px;">
											</div>
										</td>
									</tr>
									<tr>
										<td class="tdLabel">@lang('app.year')</td>
										<td class="tdInput">
											<div style="margin:10px 10px;">
												<input id="yearKey" class="easyui-combobox" name="yearKey" style="width:500px;">
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
			
			<div title="جستجو نوع 2" style="padding:10px;">
				
			</div>
			
		</div>
	
	
		
	</div>
</div>
@stop

@section('title')
	@parent
@stop