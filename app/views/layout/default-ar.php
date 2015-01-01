<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?= (isset($template['title']) && !preg_match('#^([a-z -])+$#i', $template['title']) ? $template['title'] : '') ?></title>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT" />
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
	
	<?= css_asset('default.css') ?>
	<link href="/Styles/eShia.css" rel="stylesheet" type="text/css"/>
	
	<link rel="icon" href="<?= other_asset_url('favicon.ico', '', 'icon') ?>" type="image/x-icon" />
	<link rel="shortcut icon" href="<?= other_asset_url('favicon.ico', '', 'icon') ?>" type="image/x-icon" />
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
							<span><a href="/default.htm">فارسي</a>&zwnj;</span>
							<span><a href="/Ar/DownLoad/">تحميل البرنامج</a>&zwnj;</span>
							<span><a href="/Ar/Contact/">اتصل بنا</a>&zwnj;</span>
							<span><a href="/Ar/Support/">الدعم المعنوي</a>&zwnj;</span>
							<span><a href="/Ar/News/">جديد الموقع</a>&zwnj;</span>
							<span><a href="/Ar/Poster/">الإعلانات</a>&zwnj;</span>
						</td>
						</tr>
					</table>
				</div>
				<div class="messenger-area" id="messenger">
					<table class="messengerlink">
						<tr>
						<td class="messengerlink-td1"><a href="http://payam.eshia.ir"><?= image_asset('Messenger_ar.gif', '', array('alt' => '', 'style' => 'border:0px;outline:0px')) ?></a></td>
						<td class="messengerlink-td2"><a href="http://payam.eshia.ir">لتجربة البرنامج  اضغط هنا</a></td>
						<td ></td>
						</tr>
					</table>
				</div>
				<div id="content">
					<?= (isset($template['body']) ? $template['body'] : '') ?>
				</div>
			</td>
			<td class="rightSection">
				<div id="logo">
					<?= image_asset('Logo_ar.jpg', '', array('alt' => 'Logo', 'style' => 'width:184;height:215;border:0;', 'usemap' => '#Map')) ?>
				</div>
				<div class="rightmenu">
					<ul class="vmenu fixed-menu">
						<li class="nomenu">
							<a class="vmenu-title" href="/Ar/feqh/">مدرسة الفقاهة</a>
							<a class="linknolink" style="color:#006699;font-weight:bold !important;text-indent:1.5em !important;" >بالعربية</a>
							<a href="/Ar/Feqh/Archive/" style="font-size:0.7em; text-indent:1.5em !important;">النجف الأشرف </a>
							<a href="/Ar/Feqh/Archive/Qom/" style="font-size:0.7em; text-indent:1.5em !important;">قم المقدسة(بالعربية)</a>
							<a href="/Ar/Feqh/Archive/lebanon/" style="font-size:0.7em; text-indent:1.5em !important;">لبنان</a>
							<hr class="Separator"/>
							<a class="linknolink" style="color:#006699;font-weight:bold !important;text-indent:1.5em !important;">بالفارسية</a>
							<a href="/feqh/archive/" style="font-size:0.7em; text-indent:1.5em !important;">قم المقدسة - المسجد الأعظم</a>
							<a href="/feqh/archive/qom/" style="font-size:0.7em; text-indent:1.5em !important;">قم المقدسة(بالفارسية)</a>
							<a href="/Feqh/Archive/Mashhad/" style="font-size:0.7em; text-indent:1.5em !important;">مشهد المقدسة</a>
							<a href="/Feqh/Archive/Afghanestan/" style="font-size:0.7em; text-indent:1.5em !important;">افغانستان</a>
							<a href="/Feqh/Archive/Iran/" style="font-size:0.7em; text-indent:1.5em !important;">مدن أخرى</a>
							<a href="/Feqh/Archive/Moaser/" style="font-size:0.7em; text-indent:1.5em !important;">العلماء المعاصرين</a>
							<a href="/Aqaed/Archive/" style="font-size:0.7em; text-indent:1.5em !important;">الکلام و الفلسفة</a>
							<a href="/Ar/Feqh/Archive/Translate/" style="font-size:0.7em; text-indent:1.5em !important;">تقرير الدروس باللغة العربية</a>
							<hr class="Separator"/>
							<a href="/Ar/Feqh/Timing" style="font-size:0.7em; text-indent:3em !important;">جدول الدروس</a>
							<hr class="Separator"/>
							<a href="http://ar.lib.eshia.ir" style="font-size:0.7em; text-indent:1.5em !important;">المکتبة العربية</a>
							<a href="http://ar.lib2.eshia.ir" style="font-size:0.7em; text-indent:1.5em !important;">المکتبة الفارسية</a>
							<a href="http://ar.wikifeqh.ir" style="font-size:0.7em; text-indent:1.5em !important;">ويکي الفقه</a>
							<a href="http://ar.wikiporsesh.ir" style="font-size:0.7em; text-indent:1.5em !important;">ويکي السؤال</a>
							<a class="vmenu-title" href="/Ar/eshia/">الأسئلة الشرعية</a>
							<a href="/Ar/eshia/Timing/" style="font-size:0.7em; text-indent:3em !important;">المواعيد الاجابة</a>
							<a href="/Ar/eshia/FAQ/" style="font-size:0.7em; text-indent:3em !important;">الأسئلة المبوبة</a>
							<a class="vmenu-title" href="/Ar/UserManual/">دليل الأستعمال</a>
							<a href="/Ar/userManual/Download/"  style="font-size:0.7em; text-indent:3em !important;">تحميل البرنامج</a>
							<a href="/Ar/userManual/dialog/"  style="font-size:0.7em; text-indent:3em !important;">دليل المحادثة</a>
							<a href="/Ar/userManual/Chatroom/"  style="font-size:0.7em; text-indent:3em !important;">القاعات</a>
							<a href="/Ar/userManual/accessory/"  style="font-size:0.7em; text-indent:3em !important;">الأشياء الجانبيه</a>
							<a href="/Ar/userManual/FAQ/"  style="font-size:0.7em; text-indent:3em !important;">الأسئلة الشائعة</a>
							<a class="vmenu-title" href="/Ar/Register/Register.asp?State=NewProfile">التسجيل</a>
							<a href="/Ar/Register/Register.asp?State=NewProfile" style="font-size:0.7em; text-indent:3em !important;">التسجيل</a>
							<a href="/Ar/Register/Register.asp" style="font-size:0.7em; text-indent:3em !important;">تعديل البيانات</a>
						</li>
					</ul>
				</div>
			</td>
		</tr>
		
		<tr colspan="2" id="contentfooter" align="center">
			<td>
				<p>
					<?= image_asset('BaharSound.png', '', array('alt' => 'logo')) ?>
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
		<area shape="rect" coords="5,25,177,225" href="/Ar/" alt="logo" />
	</map>
</body>
</html>