<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title></title>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT" />
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
	
	<link href="/assets/css/default.css" rel="stylesheet" type="text/css" />
	<link href="/Styles/eShia.css" rel="stylesheet" type="text/css" />
	
	@section('style') 
	   <style type="text/css">
	   
	   </style>
	@show
	<link rel="icon" href="/assets/icon/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="/assets/icon/favicon.ico" type="image/x-icon" />
</head>
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
						<td>
							<span><a href="/Ar/">العربیة</a>&zwnj;</span>
							<span><a href="/DownLoad/">دریافت نرم افزار</a>&zwnj;</span>
							<span><a href="/Contact/">ارتباط با‌ما</a>&zwnj;</span>
							<span><a href="/Support/">پشتیبانان</a>&zwnj;</span>
							<span><a href="/News/">تازه ها</a>&zwnj;</span>
							<span><a href="/Poster/">تبلیغات</a>&zwnj;</span>
						</td>
						</tr>
					</table>
				</div>
				<div class="messenger-area" id="messenger">
					<table class="messengerlink">
						<tr>
						<td class="messengerlink-td1"><a href="http://payam.eshia.ir"><img src="/assets/images/messenger.gif" style="border:0px;outline:0px" /></a></td>
						<td class="messengerlink-td2"><a href="http://payam.eshia.ir">جهت استفاده از ارتباط زنده مبتنی بر وب اینجا را کلیک کنید</a></td>
						<td ></td>
						</tr>
					</table>
				</div>
				<div id="content">@yield('content')</div>
			</td>
			<td class="rightSection">
				<div id="logo">
					<img src="/assets/images/Logo.jpg" style="width:184;height:215;border:0;" usemap="#Map" alt="Logo" />
				</div>
				<div class="rightmenu">
					<ul class="vmenu fixed-menu">
						<li class="nomenu">
							@include('partials/menu')
						</li>
					</ul>
				</div>
			</td>
		</tr>
		
		<tr colspan="2" id="contentfooter" align="center">
			<td>
				<p>
					<img src="/assets/images/BaharSound.png" alt="Logo" />
				</p>
				<p>
					<a href="http://www.baharsound.com/">www.baharsound.com,</a>
					<a href="http://www.wikifeqh.ir">www.wikifeqh.ir,</a>
					<a href="http://lib.eshia.ir">lib.eshia.ir</a>
				</p>
			</td>
			<td></td>
		</tr>
	</table>
	<map name="Map" id="Map">
		<area shape="rect" coords="6,6,177,209" href="/" alt="logo" />
	</map>
	
	
@section('javascript')

@show
</body>
</html>