<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html >
<head>
	<title>@lang('app.title')</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Expires" content="0"/>
	
	<link href="/Styles/Default.css" rel="stylesheet" type="text/css"/>
	<link href="/Styles/eshia.css" rel="stylesheet" type="text/css"/>
	<link href="/assets/css/search.css" rel="stylesheet" type="text/css"/>
	
	<link rel="shortcut icon" href="/Images/favicon.ico"/>
	
	@section('style') 
	   <style type="text/css">
	   
	   </style>
	@show
	
</head>

@php
	$locale = App::getLocale();
	$menu   = sprintf('partials.menu-%s', $locale);
	$header = sprintf('partials.header-%s', $locale);
@endphp

<body>
	<table id="mainpage" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="leftSection">
				<div class="top-header">
					<table class="top-header-table">
						<tr>
						<td>
						</td>
						</tr>
					</table>
				</div>
				<div class="header-area">
					<table class="header-links">
						<tr>
							<div class="mainsearchbox">
								<td style="width:250px;" >
									<form action="#" id="mainSearchPanel" class="searchform" onsubmit="do_search(document.getElementById('search_input').value);return false;" style="">
										<div>
											<label for="search_input" ></label>
											<input name="key" id="search_input" value="@lang('app.default_search')" class="SearchInput ui-autocomplete-input empty-search-item" autocomplete="off" onfocus="if (this.value == '@lang('app.default_search')') {this.value = ''; this.className='SearchInput ui-autocomplete-input'}" onblur="if (this.value == '') {this.value = '@lang('app.default_search')'; this.className='SearchInput ui-autocomplete-input empty-search-item'}" />
											<input type="submit" id="searchButton" value="" class="SearchKey">
										</div>
									</form>
								</td>
							</div>
							
							<td style="width:80%;">
								@include($header)
							</td>
						</tr>
					</table>
				</div>

				
				<div class="messenger-area" id="messenger">
					<div class="messengerlink">

						@if ($locale === 'ar')
							<div class="live">
								<a href="/Ar/Feqh/Timing/"><img style="border:0px;outline:0px" src="/Images/Messenger_ar.gif" />
							</div>
								</a>
								@else							
							<div class="live">
								<a href="/Feqh/Timing/"><img style="border:0px;outline:0px" src="/Images/live.gif" /></a>
							</div>
								@endif
								
						{{ $searchContentForm or '' }}
								
						<div class="course-monitoring">
											
							<a href="/Feqh/monitoring">
							@if ($locale === 'ar')
								<img src="/images/coursear.png" />
							@else
								<img src="/images/course.png" />
							@endif
							</a>
						</div>
						
						
					</div>
				</div>
				
				<div id="content">@yield('content')</div>
				
			</td>
			<td class="rightSection">
				<div id="logo">
					@if ($locale === 'ar')
						<img src="/Images/Logo_ar.jpg" width="184" height="215" border="0" usemap="#Map" alt="logo" />
					@else
						<img src="/Images/Logo.jpg" width="184" height="215" border="0" usemap="#Map" alt="logo"/>
					@endif
				</div>
				<div class="rightmenu">
						<ul class="vmenu fixed-menu">
						  <li class="nomenu">
								@include($menu)
						  </li>
						</ul>
					</div>
			</td>
		</tr>
		<tr colspan="2" id="contentfooter" style="background:url(/Images/Content_Back---down.jpg) repeat-x bottom; height:365px;" valign="bottom" align="center">
			<td>
				<p>
					<img src="/Images/BaharSound.png" alt="BaharSound"/>
				</p>
				<p>
					<a href="http://www.baharsound.com/">www.baharsound.com,</a>
					<a href="http://www.wikifeqh.ir">www.wikifeqh.ir,</a>
					<a href="http://lib.eshia.ir">lib.eshia.ir</a>
				</p>
			</td>
			<td> </td>
		</tr>
	</table>
	<map name="Map" id="Map">
		@if ($locale === 'ar')
			<area shape="rect" coords="6,6,177,209" href="/Ar" alt="logo"/>
		@else
			<area shape="rect" coords="6,6,177,209" href="/" alt="logo"/>
		@endif
	</map>
	
@section('javascript')
	<script type="text/javascript">
		function fixedEncodeURIComponent (str)
		{
			return encodeURIComponent(str).replace(/[!'()]/g, escape).replace(/\*/g, "%2A");
		}
		
		function do_search(query, teacher, course, year)
		{
			query = query.replace(/^\s+|\s+$/g, '');
			
			if (query && query != "@lang('app.default_search')" && query != "@lang('app.content_search')")
			{
				//query = query.replace(/ +/g, '_').replace(/['\0\\]+/g, '');
				query = query.replace(/['\0\\]+/g, '');
				
				if (teacher && course && year)
				{
				
					@if ($locale === 'ar')
						window.location.assign('/Ar/search/' + teacher + '/' + course + '/' + year + '/' + fixedEncodeURIComponent(query));
					@else
						window.location.assign('/search/' + teacher + '/' + course + '/' + year + '/' + fixedEncodeURIComponent(query));
					@endif
				}
				else
				{
					@if ($locale === 'ar')
						window.location.assign('/Ar/search/' + fixedEncodeURIComponent(query));
					@else
						window.location.assign('/search/' + fixedEncodeURIComponent(query));
					@endif
					
				}
				
			}
			
			return false;
		}
	</script>
@show
</body>
</html>