<style type="text/css">
<!--
        A:link {text-decoration: none ; color:#0000FF}
        A:visited {text-decoration: none;color:#0000FF} 
        A:hover {text-decoration: none ;color: ff0000}
-->
</style>

<%
var MenuColors=new Array(3);
	  MenuColors[0]="#00B4FF";  //Table Background
	  MenuColors[1]="#0308C3";  //Onmouseover Color 
	  MenuColors[2]="#00B4FF";  //Onmouseout Color

var Texts=new Array(17);
for( i=0; i<17; i++ ) {
	Texts[i]	= new Array(2);
}

		Texts[0][0]="زمينه فعاليت";
		Texts[1][0]="محصولات";
		Texts[2][0]="آموزشگاه الكترونيكي*";
		Texts[3][0]="پرسش و پاسخ زنده *";
		Texts[4][0]="آموزش زبان فارسي *";
		Texts[5][0]="ارتباط الكترونيكي *";
		Texts[6][0]="مسنجر *";
		Texts[7][0]="تازه‌ها";
		Texts[8][0]="PhoneToPhone-";
		Texts[9][0]="VoiceMail-";
		Texts[10][0]="ارتباط شيعي *";
		Texts[11][0]="كلنيك مجازي *";
		Texts[12][0]="نمونه ‌هاي عملياتي";
		Texts[13][0]="راهنماي برنامه‌ها";
		Texts[14][0]="همكاران";
		Texts[15][0]="نظرات شما";
		Texts[16][0]="تماس با ما";


		Texts[0][1]="Default.asp?ID=1";
		Texts[1][1]="Default.asp?ID=2";
		Texts[2][1]="eLearning.asp";
		Texts[3][1]="Q_A.asp";
		Texts[4][1]="FarsieLearning.asp";
		Texts[5][1]="ElectronicConnection.asp";
		Texts[6][1]="Messenger.asp";
		Texts[7][1]="Default.asp?ID=3";
		Texts[8][1]="Default.asp?ID=4";
		Texts[9][1]="Default.asp?ID=5";
		Texts[10][1]="Default.asp?ID=6";
		Texts[11][1]="Default.asp?ID=7";
		Texts[12][1]="Default.asp?ID=8";
		Texts[13][1]="Default.asp?ID=9";
		Texts[14][1]="Default.asp?ID=10";
		Texts[15][1]="Default.asp?ID=11";
		Texts[16][1]="Default.asp?ID=13";

%>
<script language=JavaScript>
imgplus=new Image(20,20);
imgplus.src="/Images/Plus.gif";
imgminuse=new Image(20,20);
imgminuse.src="/Images/Mines.gif";
function clickHandler() {
  var targetId, srcElement, targetElement;
  srcElement = window.event.srcElement;

  if (srcElement.className == "Outline" || srcElement.className == "image"){
     targetId = srcElement.id + "details";
     targetElement = document.all(targetId);
     if (targetElement.style.display == "none") {
        targetElement.style.display = "";
        document["img"+srcElement.id].src=imgminuse.src;
     } else {
        targetElement.style.display = "none";
        document["img"+srcElement.id].src=imgplus.src;
     }
  }
}

document.onclick=clickHandler
</script>