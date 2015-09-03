<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="expires" content="now">
<meta http-equiv="pragma" content="no-cache">
<meta name="description" content="Bahar Sound">
<meta name="keywords" content=" عالمان دینی، مراجع تقلید مدرسه فقاهت، پرسش پاسخ، ارتباط شیعی، پاسخگویی زنده">
<meta name="created" content="2009-07-09T12:00:00+00:00">
<meta name="updated" content="2009-07-09T12:00:00+00:00">
<meta http-equiv="Content-Language" content="fa">
	<title>آموزش الکترونیکی</title>
	<link href="../Styles/Default.css" rel="stylesheet" type="text/css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta http-equiv="Expires" content="0"/>
	<link rel="shortcut icon" href="/Images/favicon.ico"/>
<script type="text/javascript">//<![CDATA[
var rhttpProto = /^http:\/\/([^\/]+)/i;
function doMap(loc, newSite) {
	return loc.replace(rhttpProto, 'http://' + newSite);
}
function gotoOldSite(newSite) {
	newSite = newSite || '38.99.139.25';
	window.location.assign(doMap(window.location.href, newSite));
}
//]]>
</script>

<style>
body {
	font-family: Tahoma;
	margin: 0;
	padding: 0;
	background: url(http://eshia.ir/Images/Main_Page_Top.jpg) top left no-repeat;
}
a {
	text-decoration: none;
	color: #66799c;
}

a:hover {
	color:#ff6600;
}

#content {
	font-size: 14px;
	border: 1px #fff solid;
	background:  url(http://eshia.ir/Images/Content_Back.jpg) top repeat-x;
}

#register-master-table {
	width: 97%;
	padding: 40px;
	margin: 10px;
	border: #a9c3d9 2px solid;
	-webkit-border-radius: 7px;
	-moz-border-radius: 7px;
	border-radius: 7px;
	background: #eff6fc;
}

#register-table {
	width: 56%;
	margin: auto;
}

</style>
	

<SCRIPT LANGUAGE=javascript src="Global\Global.js"></SCRIPT>
</head>

<%@ Language=JavaScript %>
<!--#include file="Global/Global.asp"-->

<%
    var CRLF="\n" , CurTerm , State=ReadArg("State",'') ,LoginUserID=null , 
       UserType=3 /*1=Admin,2=Teacher,3=Student*/ , ErrUserId ,
       //IndexServerName = 'Host'
       IndexServerName = 'host'
    var Test=0
ExtraMenu=0
    CurTerm=OpenSql("Select dbo.fn_EL_Dfn_GetVlu(dbo.fn_EL_Dfn_GetID(null,'El\\Config\\CurTerm'))")
//State="EditProfile";    
    if (State=="NewProfile"){Session('UserName')='';  Session('Password')=''}
//    if (State=="PostProfile"){Session('UserName')='';  Session('Password')=''}
%>

<script LANGUAGE="jScript" RUNAT="Server">
//---------------------------------------------------------------------------------------------------------------------
function ControlLogin(){	

		  if(State=='' ||  State=="NewProfile" )return 1;

    var UserName=ReadArg("UserName",null);
    var Password=ReadArg("Password",null);
    Session('UserName')=UserName
    Session('Password')=Password    
    
//          Response.write(UserName);
//          Response.write(Password);
    
    OpenConnection() 
    var RS=Server.CreateObject("ADODB.RecordSet")    
    
		
    RS.open("SELECT ID,UserType FROM T_CMN_Person where (Username='"+UserName +"' and Password='"+Password+"' and PublicName =0 )"  ,Conn,1,1);
    if(RS.RecordCount==0)
    {
	      CloseConnection();
		  if(
State=="PostProfile" 
//|| State=="Course" || State=="Library" || State=="LibraryBook" || State=="ShowProfile" || State=="ShowFile" 
) return 1;
          Response.write('<div align="center">');
          Response.write('<table border="0"  align="center" cellspacing="0" cellpadding="0">');
          Response.write('<tr>');
          Response.write('<td >');
          Response.write('<font face="Tahoma"  color="#374c28">کد کاربری یا کلمه عبور درست وارد نشده است</font>');
          Response.write('</TD>');
          Response.write('</tr>');
          Response.write('</Table>');
          Response.write('</Div>');
       	  return 0;
    }
//    if (State!="PostProfile")
LoginUserID=RS('ID').value
//          Response.write(LoginUserID);
    
    if (UserName.toUpperCase()=='ADMIN')UserType=1
    else if (RS('UserType').value==OpenSql("Select dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\UserType\\Student')")) UserType=3
    else UserType=2
   
    RS.Close();
	CloseConnection();
	
    return 1;
}
//---------------------------------------------------------------------------------------------------------------------
function Login(){
          Session('UserName')=''
          Session('Password')=''
		  Response.write('<table border="0" cellspacing="0" cellpadding="0"  id="register-master-table">');
		  Response.write('<tr>');
		  Response.write('<TD colspan="2">');
          Response.write('<table border="0" cellspacing="0" cellpadding="0"  id="register-table">');
		 	Response.write('<tr>');
				Response.write('<TD colspan="2" class="register-td-title" >ویرایش اطلاعات</TD>');
			Response.write('</tr>');
	  Response.write('<FORM action="Register.asp?State=MainMenu" method="post" name="myform">');
	  Response.write('<tr>');
          Response.write('<TD colspan="2" class="register-td" ><p>اگر قبلا ثبت نام کرده اید با وارد کردن کد کاربری و کلمه عبور می توانید اطلاعات خودتان را ویرایش نمایید</p></TD>');
          Response.write('</tr>');



//          Response.write('<tr>');
//          Response.write('<TD colspan="2" Align="Center" ><a title="ویرایش  اطلاعات کاربری" href="Register.asp?State=NewProfile">ویرایش اطلاعات</a></TD>');
//          Response.write('</tr>');
          
          Response.write('<tr>');
          Response.write('<td class="register-td2">نـام کـاربـر</td>');
          Response.write('<td class="register-td3"><INPUT dir=ltr Required=true></td>');
          Response.write('</tr>');
		  
          Response.write('<tr>');
          Response.write('<td class="register-td2">كلمه عبور</td> ');
          Response.write('<td class="register-td3"><INPUT  name=password dir=ltr  type=password Required=true></td>');

          Response.write('<tr>');
          Response.write('<TD colspan="2" Align="Center">&nbsp;</TD>');
          Response.write('</tr>');
		  
          Response.write('</tr>');
          Response.write('<td colspan="2" class="register-td4"><input type="submit" value=" تاييد " name="B1" ></td>');
          Response.write('</tr>');
		  
		  Response.write('<tr>');
          Response.write('<TD colspan="2" Align="Center">&nbsp;</TD>');
          Response.write('</tr>');
		  
          Response.write('</Form>');
          Response.write('</Table>');
		  Response.write('</TD>');
		  Response.write('</Tr>');
		  Response.write('</Table>');
          
}
//---------------------------------------------------------------------------------------------------------------------
function MainMenu(){
		  Response.write('<div align=center>');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');

          Response.write('<tr>');

          Response.write('<td  valign="top" align ="right" dir=rtl>');
       	  Response.write('<table border="0" cellspacing="0" cellpadding="0" align="Center">');
//       	  Response.write('  <tr><td colspan=2 width="100%" Height=30><a href="Register.asp?State=EditProfile" class="new_a">ويرايش اطلاعات شخصي</a></td></tr>');
       	  
       	  if(UserType==1){
      		Response.write('  <tr><td width="100%" Height=30 ><font face="Tahoma" color="#374c28"><a href="Register.asp?State=List&Active=1&UserType='+OpenSql("Select dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\UserType\\Group Class')")+'" class="new_a">ليست گروه های درسی</a></font></td></tr>');
       		Response.write('  <tr><td width="100%" Height=30 ><font face="Tahoma" color="#374c28"><a href="Register.asp?State=List&Active=0&UserType='+OpenSql("Select dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\UserType\\Group Class')")+'" class="new_a"> ليست گروه های درسی فعال نشده</a></font></td></tr>');
       		Response.write('  <tr><td width="100%" Height=30><font face="Tahoma" color="#374c28"><a href="Register.asp?State=DelList&UserType='+OpenSql("Select dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\UserType\\Group Class')")+'" class="new_a">ليست گروه های درسی حذف شده(غير فعال)</a></font></td></tr>');

       		Response.write('  <tr><td width="100%" Height=30 ><font face="Tahoma" color="#374c28"><a href="Register.asp?State=List&Active=1&UserType='+OpenSql("Select dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\UserType\\Teacher')")+'" class="new_a">ليست اساتيد</a></font></td></tr>');
       		Response.write('  <tr><td width="100%" Height=30 ><font face="Tahoma" color="#374c28"><a href="Register.asp?State=List&Active=0&UserType='+OpenSql("Select dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\UserType\\Teacher')")+'" class="new_a"> ليست اساتيد فعال نشده</a></font></td></tr>');
       		Response.write('  <tr><td width="100%" Height=30><font face="Tahoma" color="#374c28"><a href="Register.asp?State=DelList&UserType='+OpenSql("Select dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\UserType\\Teacher')")+'" class="new_a">ليست اساتيد حذف شده(غير فعال)</a></font></td></tr>');
       		Response.write('  <tr><td width="100%" Height=30><font face="Tahoma" color="#374c28"><a href="Register.asp?State=List&Active=1&UserType='+OpenSql("Select dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\UserType\\Student')")+'" class="new_a">ليست کاربران</a></font></td></tr>');
       		Response.write('  <tr><td width="100%" Height=30><font face="Tahoma" color="#374c28"><a href="Register.asp?State=List&Active=0&UserType='+OpenSql("Select dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\UserType\\Student')")+'" class="new_a"> ليست کاربران فعال نشده</a></font></td></tr>');
       		Response.write('  <tr><td width="100%" Height=30><font face="Tahoma" color="#374c28"><a href="Register.asp?State=DelList&UserType='+OpenSql("Select dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\UserType\\Student')")+'" class="new_a">ليست کاربران حذف شده</a></font></td></tr>');
       		Response.write('  <tr><td width="100%" Height=30><font face="Tahoma" color="#374c28"><a href="Register.asp?State=CourseStudent&TermID='+CurTerm+'" class="new_a">دانشجويان ترم جاري </a></font></td></tr>');
		Response.write('  <tr><td width="100%" Height=30><font face="Tahoma" color="#374c28"><a href="Register.asp?State=Terms" class="new_a">ترمهاي ارائه شده </a></font></td></tr>');
       		}
       	  if(ExtraMenu==1)
       	    Response.write('  <tr><td width="100%" Height=30><font face="Tahoma" color="#374c28"><a href="Register.asp?State=Course&TermID='+CurTerm+'" class="new_a">دروس ارائه شده ترم جاري</a></font></td></tr>');
       	  if(UserType==2){
       	    Response.write('  <tr><td width="100%" Height=30><font face="Tahoma" color="#374c28"><a href="Register.asp?State=Course&TermID='+CurTerm+'&InstructorID='+LoginUserID+'" class="new_a">دروس ارائه شده ترم جاري توسط شما</a></font></td></tr>');
	    Response.write('  <tr><td colspan=2 width="100%" Height=30><font face="Tahoma" color="#374c28"><a href="Register.asp?State=EditProfile" class="new_a">ويرايش اطلاعات شخصي</a></font></td></tr>');
       	  }
       	  if(UserType==3 && ExtraMenu==1){
		Response.write('  <tr><td width="100%" Height=30><font face="Tahoma" color="#374c28"><a href="Register.asp?State=Status&TermID='+CurTerm+'&UserID='+LoginUserID+'" class="new_a">وضعيت تحصيلي ترم جاري</a></font></td></tr>');
		Response.write('  <tr><td width="100%" Height=30><font face="Tahoma" color="#374c28"><a href="Register.asp?State=Status&UserID='+LoginUserID+'" class="new_a">وضعيت تحصيلي کلي</a></font></td></tr>');
		Response.write('  <tr><td width="100%" Height=30><font face="Tahoma" color="#374c28"><a href="Register.asp?State=SelectTermCourse&TermID='+CurTerm+'" class="new_a">اخذ درس </a></font></td></tr>');
		Response.write('  <tr><td width="100%" Height=30><font face="Tahoma" color="#374c28"><a href="Register.asp?State=SelectTermCourseSession&TermID='+CurTerm+'" class="new_a">امتحان </a></font></td></tr>');
       	  }
       	  if(UserType==3 )
		Response.write('  <tr><td colspan=2 width="100%" Height=30><font face="Tahoma" color="#374c28"><a href="Register.asp?State=EditProfile" class="new_a">ويرايش اطلاعات شخصي</a></font></td></tr>');
       	  if(UserType!=1 && ExtraMenu==1)
        	  Response.write('  <tr><td width="100%" Height=30><font face="Tahoma" color="#374c28"><a href="Register.asp?State=SelectTermContent&TermID='+CurTerm+'" class="new_a">طرح درس </a></font></td></tr>');
       	  if(ExtraMenu==1)
       	  Response.write('  <tr><td width="100%" Height=30><font face="Tahoma" color="#374c28"><a href="Register.asp?State=Library" class="new_a">کتابخانه</a></font></td></tr>');

       	  Response.write('</table>');
          Response.write('</TD>');

          Response.write('<td valign="top">&nbsp;</td>');
          Response.write('</TR>');
          Response.write('<tr>');
          Response.write('</BR>');          
          Response.write('</BR>');          
          Response.write('</BR>');          
          Response.write('</BR>');          
          Response.write('</BR>');          
          Response.write('</BR>');          
          Response.write('</BR>');          
          Response.write('</BR>');          
          Response.write('</BR>');          
          Response.write('</BR>');          
          Response.write('</BR>');          
          Response.write('</BR>');          

          Response.write('</tr>');
          Response.write('</Table></div>');
}
//---------------------------------------------------------------------------------------------------------------------
function EditProfileClientFunction(){
		Response.write('function NumInStr(s) {');
                         Response.write('if(s.indexOf("0")!=-1 || s.indexOf("1")!=-1 ||s.indexOf("2")!=-1 ||s.indexOf("3")!=-1 ||s.indexOf("4")!=-1 ||s.indexOf("5")!=-1 ||s.indexOf("6")!=-1 ||s.indexOf("7")!=-1 ||s.indexOf("8")!=-1 ||s.indexOf("9")!=-1)return 1;else return 0;')
		Response.write('}');
		Response.write('\n');

		Response.write('function HaveExtraChars(s) {');
                         Response.write('var ExtraChars;ExtraChars=".?"; for(I=0;I<ExtraChars.length;I++) if(s.indexOf(ExtraChars[I])!=-1 )return 1; return 0;')
		Response.write('}');
		Response.write('\n');

		Response.write('function myform_onsubmit() {');

		var I;
		for(I=0;I<fT_CMN_Person.length;I++)
		{   
             		S=fT_CMN_Person[I];
               		if(S=="password")S="epassword";
               		if(S=="UserName")S="eUserName";

                       		if(Test==1)Response.write('alert("'+S+'");');
                        if(S!='GradeHozavi' && S!='Treeorder')//اگر تحصیلات حوزوی ضروری است این خط را کامنت کنید
			{
			Response.write('myform.'+S+'.value=Trim(myform.'+S+'.value);\n');
			Response.write('if(myform.'+S+'.Required=="true" && myform.'+S+'.value=="" ) '+'\n');
			Response.write('{myform.'+S+'.focus(); alert(myform.'+S+'.title'+'+" الزامی است "'+'); return false;};'+'\n'+'\n');
			}
		}

                       		if(Test==1)Response.write('alert("پایان لوپ");');
           Response.write('if(parseInt(myform.eUserName.value.substr(0,1),10)>0 || parseInt(myform.eUserName.value.substr(1,1),10)>0 || parseInt(myform.eUserName.value.substr(2,1),10)>0) '+'\n'+'{myform.eUserName.focus();alert(" سه حرف اول کد کاربری نمیتواند عدد باشد.");return false;};');
           Response.write('if(myform.eUserName.value.indexOf(" ")!=-1) '+'\n'+'{myform.eUserName.focus();alert("کد کاربری نمیتواند شامل جای خالی باشد.");return false;};');
           Response.write('if(HaveExtraChars(myform.eUserName.value)) '+'\n'+'{myform.eUserName.focus();alert("کد کاربری نمیتواند شامل حروف غیر معتبر باشد.");return false;};');

           Response.write('if(myform.eUserName.value.length<5) '+'\n'+'{myform.eUserName.focus();alert(" کد کاربری باید حداقل 5 حرف باشد.");return false;};');

           Response.write('myform.epassword.value=Trim(myform.epassword.value);\n');
           Response.write('if(myform.epassword.value.length<4) '+'\n'+'{myform.epassword.focus();alert(" کلمه عبور باید حداقل 4 حرف باشد.");return false;};');
           Response.write('if(myform.epassword.value!=myform.Password1.value) '+'\n'+'{myform.Password1.focus();alert("تکرار کلمه عبور درست وارد نشده است.");return false;};');

           Response.write('if(NumInStr(myform.FName.value)==1) '+'\n'+'{myform.FName.focus();alert("نام نمیتواند شامل عدد باشد.");return false;};');
           Response.write('if(myform.FName.value.length<3) '+'\n'+'{myform.FName.focus();alert(" نام باید حداقل 3 حرف باشد.");return false;};');

           Response.write('if(NumInStr(myform.LName.value)==1) '+'\n'+'{myform.LName.focus();alert("نام خانوادگی نمیتواند شامل عدد باشد.");return false;};');
           Response.write('if(myform.LName.value.length<3) '+'\n'+'{myform.LName.focus();alert(" نام خانوادگی باید حداقل 3 حرف باشد.");return false;};');

           Response.write('if(NumInStr(myform.City.value)==1) '+'\n'+'{myform.City.focus();alert("شهر نمیتواند شامل عدد باشد.");return false;};');
           Response.write('if(myform.City.value.length<2) '+'\n'+'{myform.City.focus();alert("شهر باید حداقل 2 حرف باشد.");return false;};');


         Response.write('str1= myform.EMail.value; if (str1!="" && str1.lastIndexOf("@")==-1) {myform.EMail.focus();alert("نشانی الکترونیکی صحیح نیست.");return false;};');
         Response.write('}');
}
//---------------------------------------------------------------------------------------------------------------------
function EditProfile(){
	OpenConnection() 
	var UserId=ReadArg("UserId",LoginUserID);
	if (UserType==1)
		Session('eUserId')=UserId;
          
          RST_CMN_Person=Server.CreateObject("ADODB.RecordSet")    
          if (UserId==null)RST_CMN_Person.open("SELECT Id,UserName,password,nicknamePersian,FName,LName,BirthDay,Province,City,Grade,GradeHozavi,Reshteh,EMail,Sex,GroupID,UserType, DescriptionPersian, Treeorder, Program FROM T_CMN_Person where -1=1"  ,Conn,1,2);
          else RST_CMN_Person.open("SELECT Id,UserName,password,nicknamePersian,FName,LName,BirthDay,Province,City,Grade,GradeHozavi,Reshteh,EMail,Sex,GroupID,UserType, DescriptionPersian, TreeOrder, Program FROM T_CMN_Person where Id="+UserId  ,Conn,1,2);
    
          fT_CMN_Person = new Array(RST_CMN_Person.Fields.Count-1);
          vT_CMN_Person = new Array(RST_CMN_Person.Fields.Count-1);

          for(I=1;I<RST_CMN_Person.Fields.Count;I++)          
          {
            fT_CMN_Person[I-1]=RST_CMN_Person.Fields(I).Name;  
            if(RST_CMN_Person.RecordCount==0) vT_CMN_Person[I-2]=null;
            else vT_CMN_Person[I-1]=RST_CMN_Person.Fields(I).Value;
          }

          Response.write('<table border="0"   cellspacing="0" cellpadding="0" id="register-master-table" >');
          Response.write('<tr>');
		  Response.write('<td>');
		  
          Response.write('<table border="0"   cellspacing="0" cellpadding="0" id="register-table" >');
          Response.write('<tr>');
          Response.write('<td valign="top" align ="right" dir=rtl>');
          
		  
		  Response.write('<div dir=rtl>');
          Response.write('<FORM action="Register.asp?State=PostProfile" method="post" name="myform"  LANGUAGE=javascript onsubmit="return myform_onsubmit()">');
	  if(ErrUserId==1)
                    {
                          Response.write('<font color=#FF0000>اين کد کاربري وجود دارد  '+ReadArg('UserName',null)+'</font>');
                          UserId=null;   
                    }
	  else if(ErrUserId==2)
                    {
                          Response.write('<font color=#FF0000>اين کد کاربري وجود دارد  '+ReadArg('eUserName',null)+'</font>');
                          ErrUserId=1;  
//                          UserId=null;   
                    }
					
		  Response.write('کد کاربری باید به زبان انگلیسی نوشته شده و پیشنهاد می کنیم که حرف اول نام بهمراه نام خانوادگی باشد. مثلا اگر نام شما محمد حسینی است کد m_hoseini  را پیشنهاد می کنیم .');

		  Response.write('<Font color="#f1a664"><strong>توجه : اگر اطلاعات نادرست وارد شود کد کاربری غیر فعال می شود</strong></font>');
		  Response.write('<tr>');
		  Response.write('<td valign="top" align ="center" dir=rtl class="register-td"></td>');
          Response.write('</tr>');
		  Response.write('<tr>');
		  Response.write('<td valign="top" align ="Right" dir=rtl>&nbsp;</td>');
		  Response.write('</tr>');
		  Response.write('<tr>');
		  Response.write('<td valign="top" align ="Right" dir=rtl>');
      
          if (UserId!=null)Response.write('<img src="PersonPic/' +RST_CMN_Person('ID')+'.jpg" border=0>');
          Response.write('<TABLE border=0 cellspacing="0" cellpadding="0" width=100%>');


          Response.write('	<TR><TD class="register-td2"><font color=#f1a664>*</Font>&nbsp;كد كاربري :</TD>');
          if(State=='NewProfile')
          Response.write('	    <TD class="register-td3"><INPUT maxLength=20 title="کد کاربری" name=eUserName size=20 dir=ltr Value="'+RST_CMN_Person('UserName')+'" Required=true> &nbsp;(انگلیسی و متناسب با نام خانوادگی)</Font></TD></tr>')
          else
          Response.write('	    <TD class="register-td3"><INPUT maxLength=20 readOnly name=eUserName size=20 dir=ltr Value="'+RST_CMN_Person('UserName')+'" Required=true> </Font></TD></tr>');
          
          Response.write('	<TR><TD class="register-td2"><font color=#f1a664>*</Font>&nbsp;كلمه عبور:</TD>');
          Response.write('	    <TD class="register-td3"><INPUT maxLength=20  title="كلمه عبور" name=epassword dir=ltr  type=password Value="'+RST_CMN_Person('Password')+'" Required=true></TD></TR>');
          
          Response.write('	<TR><TD class="register-td2"><font color=#f1a664>*</Font>&nbsp;تاييد كلمه عبور:</TD>');
          Response.write('	    <TD class="register-td3"><INPUT maxLength=20  title="تاييد كلمه عبور" name=Password1 type=password dir=ltr  Value="'+RST_CMN_Person('Password')+'"  Required=true></TD></TR>');
          
          Response.write('	<TR><TD class="register-td2"><font color=#f1a664>*</Font>&nbsp;نام:</TD>');
          if(ErrUserId==1)  S=ReadArg('FName',null); else S=RST_CMN_Person('fName');
          Response.write('	    <TD class="register-td3"><INPUT maxLength=30 title="نام"  name=FName size=20   Value="'+S+'"  Required=true LANGUAGE=javascript onkeypress="return FARKeyPress()"></TD>');

          Response.write('	<TR><TD class="register-td2"><font color=#f1a664>*</Font>&nbsp;نام خانوادگي:</TD>');
          if(ErrUserId==1)  S=ReadArg('LName',null); else S=RST_CMN_Person('lName');
          Response.write('	     <TD class="register-td3"><INPUT maxLength=40 title="نام خانوادگي" name=LName size=20  Value="'+S+'"  Required=true LANGUAGE=javascript onkeypress="return FARKeyPress()"></TD>');
          
          if(ErrUserId==1)  S=ReadArg('nicknamePersian',null); else S=RST_CMN_Person('LName');
          Response.write('	    <TD ><INPUT maxLength=30 Size=20 name=nicknamePersian  style="DISPLAY: none" Value="'+S+'"  LANGUAGE=javascript onkeypress="return FARKeyPress()"> </TD></Tr>');
       
          Response.write('<TR><TD class="register-td2"><font color=#f1a664>*</Font>&nbsp;نوع كاربر:</TD><TD class="register-td3">');

          if (RST_CMN_Person.recordcount!=0) S=RST_CMN_Person("UserType").Value
          else S=ReadArg('UserType',null);
          if (UserType==1)var disabled='';
          else var disabled = 'disabled';
		  CreateDBCompoBox('UserType','true',disabled,"Declare @PID as int Select @PID=dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\UserType') SELECT ID , Vlu FROM T_CMN_DFN where PID = @PID ",S,145,0) 	
          Response.write('</TD></TR>');

          Response.write('	<TR><TD class="register-td2"><font color=#f1a664>*</Font>&nbsp;گروه کاربر:</TD><TD class="register-td3">');
          if (RST_CMN_Person.recordcount!=0) S=RST_CMN_Person("GroupID").Value
		else S=ReadArg('GroupID',null);
          if (UserType==1)var disabled='';
		else var disabled = 'disabled';
	  CreateDBCompoBox('GroupID','true',disabled,"Declare @PID as int Select @PID=dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\Groups') SELECT ID , Vlu FROM T_CMN_DFN where PID = @PID ",S,145,0) 	
          Response.write('</TD></TR>');


          if (UserType==1) Response.write('	<TR><TD class="register-td2"><font color=#f1a664>*</Font>&nbsp;شماره برنامه:</TD>');
          if(ErrUserId==1)  S=ReadArg('Program',null); 
		else S=RST_CMN_Person('Program');
          if (UserType==1)var disabled=''; 
		else var disabled = 'none';
          Response.write('	    <TD ><INPUT maxLength=30 Size=20 name=Program  style="DISPLAY: '+disabled+'"  Value="'+S+'"  > </TD></Tr>');


          if (UserType==1) Response.write('	<TR class="register-td2"><TD><font color=#f1a664>*</Font>&nbsp;توضیح کاربر:</TD>');
          if(ErrUserId==1)  S=ReadArg('DescriptionPersian',null); 
		else S=RST_CMN_Person('DescriptionPersian');
          if (UserType==1)var disabled=''; 
		else var disabled = 'none';
          Response.write('	    <TD><INPUT maxLength=40 title="توضیح" Size=20 name=DescriptionPersian  style="DISPLAY: '+disabled+'"  Value="'+S+'"  LANGUAGE=javascript onkeypress="return FARKeyPress()"></TD>');


          if (UserType==1) Response.write('	<TR class="register-td2"><TD><font color=#f1a664>*</Font>&nbsp;ترتیب نمایش نام کاربر:</TD>');
          if(ErrUserId==1)  S=ReadArg('TreeOrder',null); 
		else S=RST_CMN_Person('TreeOrder');
          if (UserType==1)var disabled=''; 
		else var disabled = 'none';
          Response.write('	    <TD><INPUT maxLength=30 Size=20 name=TreeOrder  style="DISPLAY: '+disabled+'"  Value="'+S+'"  > </TD></Tr>');

          Response.write('	<TR><TD class="register-td2"><font color=#f1a664>*</Font>&nbsp;محل اقامت:</TD><TD class="register-td3">');
          if (RST_CMN_Person.recordcount!=0) S=RST_CMN_Person("Province").Value
          else S=ReadArg('Province',null);
		  CreateDBCompoBox('Province','true','',"Declare @PID as int Select @PID=dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\City')  SELECT ID , Vlu FROM T_CMN_DFN where PID = @PID",S,145,1,'محل اقامت') 	
          Response.write('		</TD></TR>');

          Response.write('	<TR><TD class="register-td2"><font color=#f1a664>*</Font>&nbsp;شهر:</TD>');
          if(ErrUserId==1)  S=ReadArg('City',null); else S=RST_CMN_Person('City');
          Response.write('	    <TD class="register-td3"><INPUT maxLength=30 title="شهر" name=City size=20  Value="'+S+'" Required=true LANGUAGE=javascript onkeypress="return FARKeyPress()"></TR>');

          Response.write('        <TR><TD class="register-td2"><font color=#f1a664>*</Font>&nbsp;ميزان تحصيلات:</TD>');
          Response.write('          <TD class="register-td3">');
          if (RST_CMN_Person.recordcount!=0) S=RST_CMN_Person("Grade").Value
          else S=ReadArg('Grade',null);
		  CreateDBCompoBox('Grade','true','',"Declare @PID as int Select @PID = dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\Grade') SELECT ID , Vlu FROM T_CMN_DFN where PID = @PID",S,145,1,'میزان تحصیلات');
          Response.write('  </TD></TR>');

          Response.write('        <TR><TD class="register-td2"><font color=#f1a664>*</Font>&nbsp;ميزان تحصيلات حوزوی:</TD>');
          Response.write('          <TD class="register-td3">');
          if (RST_CMN_Person.recordcount!=0) S=RST_CMN_Person("GradeHozavi").Value
          else S=ReadArg('GradeHozavi',null);
		  CreateDBCompoBox('GradeHozavi','true','',"Declare @PID as int Select @PID = dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\GradeHozavi') SELECT ID , Vlu FROM T_CMN_DFN where PID = @PID",S,145,1,'میزان تحصیلات حوزوی');
          Response.write('  </TD></TR>');

          Response.write('	<TR><TD class="register-td2">تلفن:</TD>');
          if(ErrUserId==1)  S=ReadArg('Reshteh',null); else S=RST_CMN_Person('Reshteh');
          Response.write('            <TD class="register-td3"><INPUT maxLength=20 title="تلفن" name=Reshteh size=20 dir=ltr Value="'+S+'" LANGUAGE=javascript onkeypress="return FARKeyPress()"> </TD></tr>');
          Response.write('	<TR><TD class="register-td2"><font color=#f1a664>*</Font>&nbsp;تاريخ تولد:</TD>');
          if(ErrUserId==1)  S=ReadArg('BirthDay',null); else S=RST_CMN_Person('BirthDay');
          Response.write('	    <TD class="register-td3"><INPUT dir=ltr maxLength=8 title="تاريخ تولد" name=BirthDay size=20 Value="'+S+'" Required=true></TD></TR>');
          Response.write('	<TR><TD class="register-td2"><font color=#f1a664>*</Font>&nbsp;نشاني الكترونيكي:</TD>');
          if(ErrUserId==1)  S=ReadArg('EMail',null); else S=RST_CMN_Person('EMail');
          Response.write('	    <TD class="register-td3"><INPUT maxLength=40 title="نشانی الکترونیکی" name=EMail size=20 dir=ltr Value="'+S+'" Required=true>&nbsp;نشانی فعال باشد</TD></TR>');
          Response.write('	<TR><TD class="register-td2"><font color=#f1a664>*</Font>&nbsp;جنسيت:</td>');
          Response.write('	    <td class="register-td3">');

          if (RST_CMN_Person.recordcount!=0) S=RST_CMN_Person("Sex").Value
          else S=ReadArg('Sex',null);
		  CreateDBCompoBox('Sex','true','',"Declare @PID as int Select @PID=dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\Sex') SELECT ID , Vlu FROM T_CMN_DFN where PID = @PID",S,145,1,'جنسیت');
          RST_CMN_Person.Close();
		  Response.write('</td>');
		  Response.write('</tr>');
          Response.write('</TD></tr>');
          Response.write('</TABLE>');
		  Response.write('<p>&nbsp;</p>');
          Response.write('<p align=center class="register-td4"><input type="submit" value=" تاييد " name="B1"></p>');
          Response.write('</form></div>');
          Response.write('</TD>');

          Response.write('<td valign="top">&nbsp;</td>');
          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');
          Response.write('</Table>');

          Response.write('</td>');
		  Response.write('</tr>');
          Response.write('</Table>');

	CloseConnection();
}
//---------------------------------------------------------------------------------------------------------------------
function PostProfile(){
	OpenConnection() 
    var UserId=ReadArg("UserId",LoginUserID);
	if (UserType==1)
	{
    UserId=Session('eUserId')
	}
    if(Test==1)      Response.write("UserID="+UserId+"<BR>");

/*    RST_CMN_Person=Server.CreateObject("ADODB.RecordSet")    
    if (UserId==null)RST_CMN_Person.open("SELECT * FROM T_CMN_Person where -1=1"  ,Conn,1,2);
    else RST_CMN_Person.open("SELECT * FROM T_CMN_Person where Id="+UserId  ,Conn,1,2);
    
    fT_CMN_Person = new Array(RST_CMN_Person.Fields.Count-1);
    vT_CMN_Person = new Array(RST_CMN_Person.Fields.Count-1);
    var I;
          Response.write("addas<BR>");
          Response.write(UserId+"<BR>");
    for(I=0;I<RST_CMN_Person.Fields.Count;I++){
       fT_CMN_Person[I]=RST_CMN_Person.Fields(I).Name;  
       S=fT_CMN_Person[I];
          Response.write(S+"<BR>");
       if(S=="password")S="epassword"
       if(S=="UserName")S="eUserName"
          Response.write(S+"<BR>");
       if (RST_CMN_Person.RecordCount==0 )vT_CMN_Person[I]=ReadArg(S,null);
       else vT_CMN_Person[I]=ReadArg(S,RST_CMN_Person.Fields(I).value);
          Response.write(vT_CMN_Person[I]+"<BR>");
       }

*/
    RST_CMN_Person=Server.CreateObject("ADODB.RecordSet")
    if (UserId==null)
      RST_CMN_Person.open("SELECT ID, UserName, password, nicknamePersian,  FName, LName, BirthDay, Province, City, Grade,GradeHozavi, Reshteh, EMail, Sex, GroupID, UserType, DescriptionPersian, TreeOrder, Program FROM T_CMN_Person where -1=1" ,Conn,1,2);
    else
      RST_CMN_Person.open("SELECT ID, UserName, password, nicknamePersian,  FName, LName, BirthDay, Province, City, Grade, GradeHozavi, Reshteh, EMail, Sex, GroupID, UserType, Active, DescriptionPersian, TreeOrder, Program FROM T_CMN_Person where Id="+UserId ,Conn,1,2);
    fT_CMN_Person = new Array(RST_CMN_Person.Fields.Count-1);
    vT_CMN_Person = new Array(RST_CMN_Person.Fields.Count-1);
    for(I=1;I<RST_CMN_Person.Fields.Count;I++){
       fT_CMN_Person[I-1]=RST_CMN_Person.Fields(I).Name;  
       S=fT_CMN_Person[I-1];
       if(S=="password")S="epassword"
       if(S=="UserName")S="eUserName"
       if(S=="nicknamePersian")S="LName"
       if(S=="Active") vT_CMN_Person[I-1]=0
       else vT_CMN_Person[I-1]=ReadArg(S,null);
       if (fT_CMN_Person[I-1]=='UserType' && vT_CMN_Person[I-1]==null)vT_CMN_Person[I-1]=100601;
       if (fT_CMN_Person[I-1]=='TreeOrder' && (vT_CMN_Person[I-1]==null || vT_CMN_Person[I-1]=='') )vT_CMN_Person[I-1]=0;
       if (fT_CMN_Person[I-1]=='Program' && (vT_CMN_Person[I-1]==null || vT_CMN_Person[I-1]==''))vT_CMN_Person[I-1]=0;
       if (fT_CMN_Person[I-1]=='GroupID' && vT_CMN_Person[I-1]==null)vT_CMN_Person[I-1]=100400;
       if (fT_CMN_Person[I-1]=='Program' && vT_CMN_Person[I-1]==null)vT_CMN_Person[I-1]=1;
       if (fT_CMN_Person[I-1]=='DescriptionPersian' && vT_CMN_Person[I-1]==null)vT_CMN_Person[I-1]='';
 
       if (fT_CMN_Person[I-1]=='TreeOrder' && ((vT_CMN_Person[I-1]==null) ||(UserId==null)))vT_CMN_Person[I-1]=100;

//       if (fT_CMN_Person[I-1]=='UserType' && vT_CMN_Person[I-1]==100601)vT_CMN_Person[I-2]=100400;
//       if (fT_CMN_Person[I-1]=='UserType' && vT_CMN_Person[I-1]==100602)vT_CMN_Person[I-2]=100401;
       }      

    ErrUserId=0;
    if (RST_CMN_Person.RecordCount==0) 
       try
       {  

         RST_CMN_Person.AddNew(fT_CMN_Person,vT_CMN_Person);
         
       }
       catch(exception)
       {         
       State="NewProfile";
       UserId==null;
       ErrUserId=1;     
       }  
      else{
       try{
       if(Test==1){
          Response.write("------------------------------------------<BR>");
    for(I=0;I<RST_CMN_Person.Fields.Count-1;I++){
          Response.write(fT_CMN_Person[I]+"="+vT_CMN_Person[I]+"<BR>");}
         }
         RST_CMN_Person.Update(fT_CMN_Person,vT_CMN_Person);         
}
       catch(exception)
       {         
       State="EditProfile";
       ErrUserId=2;     
       }  
         }
	CloseConnection();
    if(State=="EditProfile" || ErrUserId==1){
		EditProfile();
		return
    }
          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');

          Response.write('<tr>');

          Response.write('<td valign="top" align ="right" dir=rtl>');
/*    for(I=0;I<17;I++)
    {
         Response.write(vT_CMN_Person[I]);
         Response.write(fT_CMN_Person[I]);
         Response.write('<BR>');
    }     */
          Response.write('<div dir=rtl>');
          Response.write('<p align=right><font color="#374c28"><a href="Register.asp" class="new_a">بازگشت به صفحه ثبت نام</a><p>');
          Response.write('<p align=center>');
          Response.write('اطلاعات وارد شد. شما اکنون می توانید با کد خودتان وارد شوید.</p></div>');
          Response.write('</TD>');

          Response.write('<td valign="top">&nbsp;</td>');
          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');
          Response.write('</Table>');
          Response.write('</Div>');
}
//---------------------------------------------------------------------------------------------------------------------
function List(){
	OpenConnection();
    if (! IsNull( ReadArg("UserId") )) 
      if (ReadArg("SubState")=="Delete" ) 
      Conn.Execute("Update T_CMN_Person set LogicalDelete=1 WHERE ID="+ReadArg("UserId") );
      else if (ReadArg("SubState")=="Active" )
	  Conn.Execute("Update T_CMN_Person set Active=Active ^ 1 WHERE ID="+ReadArg("UserId") );
          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');

    Response.write('<td valign="top">');
    Response.write('<p align=right><font color="#374c28"><a href="Register.asp?State=MainMenu" class="new_a">بازگشت به صفحه ثبت نام</a></font><p>');

    if(ReadArg("UserType")==OpenSql("Select dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\UserType\\Teacher')")) 
    {var S="Select 'ليست اساتيد'"; 
    } 
    else var S="Select 'ليست کاربران'";
	CreateDBGrid(S,
		"Declare @UserType as int,@Active as int "+CRLF+
		"Set @UserType ="+ReadArg("UserType")+CRLF+
		"Set @Active ="+ReadArg("Active")+CRLF+

		"Select "+CRLF+
		"'<font face=Tahoma ><a href=Register.asp?State=ShowProfile&UserId='+cast(Id as varchar)+'>'+ Username +'</a></font>',"+CRLF+
		"'<font face=Tahoma ><a href=Register.asp?State=ShowProfile&UserId='+cast(Id as varchar)+'>'+ nicknamePersian +'</a></font>',"+CRLF+
		"'<font face=Tahoma ><a href=Register.asp?State=EditProfile&UserId='+cast(Id as varchar)+'>'+ 'ويرايش'+'</a></font>',"+CRLF+
 		"'<font face=Tahoma ><a href=Register.asp?State=List&SubState=Delete&Active='+cast(@Active as varchar)+'&UserType='+cast(@UserType as varchar)+'&UserId='+cast(Id as varchar)+'>'+ 'حذف'          +'</a></font>',"+CRLF+
		"'<font face=Tahoma ><a href=Register.asp?State=List&SubState=Active&Active='+cast(@Active as varchar)+'&UserType='+cast(@UserType as varchar)+'&UserId='+cast(Id as varchar)+'>'+ 'فعال/غیرفعال' +'</a></font>'"+CRLF+
		"FROM T_CMN_Person where LogicalDelete=0 and UserType=@UserType and Active=@Active"+CRLF,
 
		["<font face=Tahoma  color=#003399>ردیف</font>","<font  face=Tahoma  color=#003399>کد کاربری</font>","<font  face=Tahoma  color=#003399>نام</font>","<font face=Tahoma  color=#003399>ويرايش</font>","<font  face=Tahoma  color=#003399>حذف</font>","<font  face=Tahoma  color=#003399>فعال/غیرفعال</font>"],
		"#6699ff",30,"","500",30,1);
          
          Response.write('</TD>');

          Response.write('<td valign="top">&nbsp;</td>');
          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');
          Response.write('</Div>');
	CloseConnection();
}
//---------------------------------------------------------------------------------------------------------------------
function DelList(){
	OpenConnection();
    if (! IsNull( ReadArg("UserId") )) 
      Conn.Execute("Update T_CMN_Person set LogicalDelete=0 WHERE ID="+ReadArg("UserID") );

          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');
    Response.write('<td valign="top">');
    Response.write('<p align=right><font color="#374c28"><a href="Register.asp?State=MainMenu" class="new_a">بازگشت به صفحه ثبت نام</a><p>');
          
    if(ReadArg("UserType")==OpenSql("Select dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\UserType\\Teacher')")) var S="Select 'ليست اساتيد حذف شده ' "; else var S="Select 'ليست کاربران حذف شده '";
	CreateDBGrid(S,
		"Declare @UserType as int"+CRLF+
		"Set @UserType ="+ReadArg("UserType")+CRLF+

		"Select "+CRLF+
		"'<a href=Register.asp?State=ShowProfile&UserId='+cast(Id as varchar)+'>'+ nicknamePersian +'</a>',"+CRLF+
		"'<a href=Register.asp?State=DelList&UserType='+cast(@UserType as varchar)+'&UserId='+cast(Id as varchar)+'>'+ 'بازگرداندن' +'</a>'"+CRLF+
		"FROM T_CMN_Person where LogicalDelete=1 and UserType=@UserType"+CRLF,
 
		["<font color=#003399>نام</font>","<font color=#003399>بازگرداندن</font>"],
		"#6699ff",30,"","350",30);
		
		
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');
          Response.write('</Table>');
          Response.write('</Div>');
	CloseConnection();
}    
//---------------------------------------------------------------------------------------------------------------------
function ShowProfile(){
	OpenConnection() 
    var RS=Server.CreateObject("ADODB.RecordSet")
    RS.open("SELECT UserName, nicknamePersian,  FName,BirthDay, (Select Vlu from T_CMN_DFN where ID=Province) Province,City,(Select Vlu from T_CMN_DFN where ID=Sex)Sex, LName, (Select Vlu from T_CMN_DFN where ID=Grade)GradeName,(Select Vlu from T_CMN_DFN where ID=GradeHozavi)GradeHozaviName, Reshteh, EMail "+
                   "FROM T_CMN_Person "+
                   "Where Id ="+ReadArg("UserId") ,Conn,1,1);

          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');


          Response.write('<td valign="top" align ="right" dir=rtl>');
          Response.write('<div dir=rtl>');
          Response.write('<p align=right><font color="#374c28"><a href="Register.asp?State=MainMenu" class="new_a">بازگشت به صفحه ثبت نام</a><p>');
          Response.write('<p align="center"><b><font color=#1C8E58>مشخصات كاربر</font></b></p>');

          Response.write('<table border="0" cellspacing="0" cellpadding="0" align="Center">');
            Response.write('<tr><td height=30><font face="Tahoma" color=#000000>كد كاربري:</font></td><td width=100></td><td ><font face="Tahoma"  color=#1C8E58>'+RS("UserName")+'</font></td></tr>');
            Response.write('<tr><td height=30><font face="Tahoma" color=#000000>اسم مستعار:</font></td><td width=100></td><td ><font face="Tahoma"  color=#1C8E58>'+RS("nicknamePersian")+'</font></td></tr>');
//            Response.write('<tr><td height=30><font face="Tahoma" color=#000000>توصيف كاربر:</font></td><td width=100></td><td ><font face="Tahoma" color=#1C8E58>'+RS("DescriptionPersian")+'</font></td></tr>');
            Response.write('<tr><td height=30><font face="Tahoma"  color=#000000>نام:</font></td><td width=100></td><td ><font face="Tahoma"  color=#1C8E58>'+RS("FName")+'</font></td></tr>');
            Response.write('<tr><td height=30><font face="Tahoma"  color=#000000>نام خانوادگي:</font></td><td width=100></td><td ><font face="Tahoma"  color=#1C8E58>'+RS("LName")+'</font></td></tr>');
            Response.write('<tr><td height=30><font face="Tahoma"  color=#000000>ميزان تحصيلات:</font></td><td width=100></td><td ><font face="Tahoma"  color=#1C8E58>'+RS("GradeName")+'</font></td></tr>');
            Response.write('<tr><td height=30><font face="Tahoma"  color=#000000>ميزان تحصيلات حوزوی:</font></td><td width=100></td><td ><font face="Tahoma"  color=#1C8E58>'+RS("GradeHozaviName")+'</font></td></tr>');
            Response.write('<tr><td height=30><font face="Tahoma"  color=#000000>تلفن</font></td><td width=100></td><td ><font face="Tahoma"  color=#1C8E58>'+RS("Reshteh")+'</font></td></tr>');
            Response.write('<tr><td height=30><font face="Tahoma"  color=#000000>محل زندگی</font></td><td width=100></td><td ><font face="Tahoma"  color=#1C8E58>'+RS("Province")+'</font></td></tr>');
            Response.write('<tr><td height=30><font face="Tahoma"  color=#000000>شهر</font></td><td width=100></td><td ><font face="Tahoma"  color=#1C8E58>'+RS("City")+'</font></td></tr>');
            Response.write('<tr><td height=30><font face="Tahoma"  color=#000000>نشاني الكترونيكي:</font></td><td width=100></td><td ><font face="Tahoma"  color=#1C8E58>'+RS("EMail")+'</font></td></tr>');
            Response.write('<tr><td height=30><font face="Tahoma"  color=#000000>جنسیت:</font></td><td width=100></td><td ><font face="Tahoma"  color=#1C8E58>'+RS("Sex")+'</font></td></tr>');
          Response.write('</table></div>');

          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');
          Response.write('</Table>');
          Response.write('</Div>');

    RS.Close();
	CloseConnection();
}    
//---------------------------------------------------------------------------------------------------------------------
function Course(){
    
	var TermID=ReadArg("TermID");
	var InstructorID=ReadArgNotNull("InstructorID","Null")

          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');

    Response.write('<td valign="top" align ="right" >');
    Response.write('<p align=right><font color="#374c28"><a href="Register.asp?State=MainMenu" class="new_a">بازگشت به صفحه ثبت نام</a><p><br>');
    
	CreateDBGrid("Select 'درسهاي ارائه شده ' + Cast(Vlu as varchar) from T_EL_DFN where ID="+TermID,
		"Declare @TermID as int"+CRLF+
		"Set @TermID ="+TermID+CRLF+
		"Declare @InstructorID as int"+CRLF+
		"Set @InstructorID ="+InstructorID+CRLF+
		"Declare @UserType as int"+CRLF+
		"Set @UserType ="+UserType+CRLF+
		"Declare @LoginUserID as int"+CRLF+
		"Set @LoginUserID ="+LoginUserID+CRLF+

		"Select "+CRLF+
		"Case When @LoginUserID is null then (Select Vlu from T_EL_DFN where ID = CourseID)  else '<a href = Register.asp?State=CourseStudent&TermCourseID='+Cast(ID as varchar)+'>'+(Select Vlu from T_EL_DFN where ID = CourseID)+'</a>' end as CourseName ,"+CRLF+
		" (Select Vlu from T_CMN_DFN where DayID = ID)as DayName , (Select Vlu from T_EL_DFN where ID = TimeID)as TimeName, "+CRLF+
		"'<a href = Register.asp?State=ShowProfile&UserID='+cast(InstructorID as varchar)+'>' + (Select nicknamePersian from T_CMN_Person where Id = InstructorID) +'</a>'  ,"+CRLF+
		"ID = case when @UserType = 1 then '<a href= Register.asp?State=CourseEntry&TermCourseID='+cast(ID as varchar) +'>' + cast(ID as varchar)+'</a>'"+CRLF+
		"	else cast(ID as varchar)"+CRLF+
		"end"+CRLF+
		"from T_EL_TermCourse  "+CRLF+
		"where  TermID=@TermID and (@InstructorID is null or InstructorID=@InstructorID)"+CRLF,
 
		["<font color=#003399>نام درس</font>","<font color=#003399>روز</font>","<font color=#003399>ساعت</font>","<font color=#003399>استاد</font>" , "<font color=#003399>كد درس</font>"],
		"#6699ff",30,"","350",30)
    
    if(UserType=='1')
      Response.write('<p bgcolor="#6699ff" align=center><a href= "Register.asp?State=CourseEntry" class="new_a">درس جديد  </a></p>');
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');

          Response.write('</Div>');
}
function CourseEntry(){
	OpenConnection() 
	var TermCourseID=ReadArg("TermCourseID","");
	var TermID=ReadArg("TermID");
	var CourseID=ReadArg("CourseID");
	var DayID=ReadArg("DayID");
	var TimeID=ReadArg("TimeID");
	var InstructorID=ReadArg("InstructorID");
	if (!IsNull(TermID))
	{
          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');

          Response.write('<tr>');

	    Response.write('<td valign="top" align ="right" dir=rtl>');
		if (IsNull(TermCourseID))
     		Conn.Execute ("Insert into T_EL_TermCourse (TermID,CourseID,DayID,TimeID,InstructorID) Values ("+TermID+","+CourseID+","+DayID+","+TimeID+","+InstructorID+ ")",'',1);
		else Conn.Execute ("Update T_EL_TermCourse Set TermID=" +TermID+" , CourseID="+CourseID+",DayID="+DayID+",TimeID="+TimeID+",InstructorID="+InstructorID+" where ID="+TermCourseID,'',1);

        Response.write('<p align=right>درس ثبت شد.<p><br><br><br>');
        Response.write('<p align=right><font color="#374c28"><a href="Register.asp?State=MainMenu" class="new_a">بازگشت به صفحه ثبت نام</a><p><br><br><br>');
		CloseConnection();
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');


          Response.write('</Div>');
		return;
	}

          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');

    Response.write('<td valign="top" align ="Center" dir=rtl>');
    Response.write('<FORM action="Register.asp?State=CourseEntry&TermCourseID='+TermCourseID+'" method="post" name="myform"  >');          
    Response.write('<table border="0" cellspacing="0" cellpadding="0" align="Center">');
	if(!IsNull(TermCourseID))
	{
        var RS=Server.CreateObject("ADODB.RecordSet")
        RS.open('Select * from T_EL_TermCourse where ID = '+TermCourseID  ,Conn,1,1);
		TermID=RS("TermID").Value;
		CourseID=RS("CourseID").Value;
		DayID=RS("DayID").Value;
		TimeID=RS("TimeID").Value;
		InstructorID=RS("InstructorID").Value;
	    RS.Close();          
	}
          Response.write('<TR><TD bgcolor="#6699ff">ترم</TD><TD>');
          CreateDBCompoBox('TermID','true','',"Declare @PID as int Select @PID= dbo.fn_EL_Dfn_GetID (Null , 'El\\Terms') SELECT ID , Vlu FROM T_EL_DFN where PID = @PID order by id desc",TermID,150);
          Response.write('	</TD></TR>');

          Response.write('<TR><TD bgcolor="#6699ff">درس</TD><TD>');
          CreateDBCompoBox('CourseID','true','',"Declare @PID as int Select @PID= dbo.fn_EL_Dfn_GetID (Null , 'El\\Course') SELECT ID , Vlu FROM T_EL_DFN where PID = @PID",CourseID,150);
          Response.write('</TD></TR>');

          Response.write('<TR><TD bgcolor="#6699ff">روز</TD><TD>');
          CreateDBCompoBox('DayID','true','',"Declare @PID as int Select @PID= dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\Days') SELECT ID , Vlu FROM T_CMN_DFN where PID = @PID",DayID,150);
          Response.write('</TD></TR>');

          Response.write('<TR><TD bgcolor="#6699ff">ساعت</TD><TD>');
          CreateDBCompoBox('TimeID','true','',"Declare @PID as int Select @PID= dbo.fn_EL_Dfn_GetID (Null , 'El\\Times') SELECT ID , Vlu FROM T_EL_DFN where PID = @PID",TimeID,150);
          Response.write('</TD></TR>');

          Response.write('<TR><TD bgcolor="#6699ff">استاد</TD><TD>');
          CreateDBCompoBox('InstructorID','true','',"Declare @PID as int Select @PID = dbo.fn_CMN_Dfn_GetID (Null , 'Constants\\UserType\\Teacher') SELECT ID , nicknamePersian as Vlu FROM T_CMN_Person where UserType = @PID",InstructorID,150);
          Response.write('</TD></TR>');
          
    Response.write('</table>');
    Response.write('<BR><BR><BR><BR><input type="submit" value="تاييد" name="B1" >');
    Response.write('</Form>');       	  
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');


          Response.write('</Div>');
	CloseConnection();
}
//---------------------------------------------------------------------------------------------------------------------
function SelectTermCourse(){
	OpenConnection() 
    var RS=Server.CreateObject("ADODB.RecordSet")
	var TermID=ReadArg("TermID");
	RS.open(
	"Declare @UserID as int"+CRLF+
	"Set @UserID ="+LoginUserID+CRLF+

	"Declare @TermID as int"+CRLF+
	"Set @TermID = "+TermID+CRLF+

	"Select ID, "+CRLF+
		"(Select Vlu from T_EL_Dfn where ID = CourseID) Course,"+CRLF+
		"(Select Vlu from T_CMN_Dfn where ID = DayID) Day,"+CRLF+
		"(Select Vlu from T_EL_Dfn where ID = TimeID) Time,"+CRLF+
		"(Select nicknamePersian from T_CMN_Person where ID= InstructorID) Instructor,"+CRLF+
		"(Select 1 from T_EL_TermCourseStudent where StudentID = @UserID and TermCourseID=T_EL_TermCourse.ID) IsSelected "+CRLF+
	"from T_EL_TermCourse "+CRLF+
	"where TermID=@TermID AND"+CRLF+
	"(Select Count(Vlu) from T_EL_DFN "+CRLF+
	"where PID = CourseID and "+CRLF+
	"Vlu not in ("+CRLF+
	"Select CourseID From T_EL_TermCourse ,T_EL_TermCourseStudent "+CRLF+
	"where TermCourseID = T_EL_TermCourse.ID AND TermID<@TermID and StudentID = @UserID"+CRLF+
	") )= 0",Conn,1,1);
	
    if(ReadArg("SubState")=="Post"){
          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');

	    Response.write('<td valign="top" align ="right" dir=rtl>');
	    while(!RS.EOF){
			if (ReadArg('checkbox'+RS('ID'))=='on')
     		Conn.Execute ('if not exists(Select 1 from T_EL_TermCourseStudent where StudentID='+LoginUserID+' and TermCourseID ='+RS('ID')+' )insert into T_EL_TermCourseStudent( StudentID , TermCourseID) values('+LoginUserID+','+RS('ID')+')','',1);
     		else Conn.Execute ('delete T_EL_TermCourseStudent where StudentID ='+LoginUserID+' and TermCourseID = '+RS('ID'),'',1);
        RS.MoveNext();
     	}	
        Response.write('<p align=right>دروس اخذ شد.<p><br><br><br>');
        Response.write('<p align=right><font color="#374c28"><a href="Register.asp?State=MainMenu" class="new_a">بازگشت به صفحه ثبت نام</a><p><br><br><br>');
    	RS.Close();
		CloseConnection();
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');


          Response.write('</Div>');
		return;
    }
          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');

    Response.write('<td valign="top" align ="Center" dir=rtl>');
    Response.write('<B>اخذ درس</B>');
    Response.write('<Table>');
    Response.write('<FORM action="Register.asp?State=SelectTermCourse&TermID='+TermID+'&SubState=Post" method="post" name="myform"  >');          
    Response.write('<tr>');
    Response.write('<td height=30 width=150 bgcolor="#6699ff"><font color="#003399"> اخذ</font></td>');
    Response.write('<td height=30 width=150 bgcolor="#6699ff"><font color="#003399">نام درس  </font></td>');
    Response.write('<td height=30 width=100 bgcolor="#6699ff"><font color="#003399">روز </font></td>');
    Response.write('<td height=30 width=100 bgcolor="#6699ff"><font color="#003399">ساعت</font></td>');
    Response.write('<td height=30 width=150 bgcolor="#6699ff"><font color="#003399">استاد</font></td>');
    Response.write('</tr>');
    while(!RS.EOF){
	    Response.write('<TR>');
	    Response.write('<TD><INPUT name=checkbox'+RS('ID')+' id=checkbox'+RS('ID')+' type=checkbox ');
	    if(RS('IsSelected').Value==1)Response.write(' CHECKED ');
	    Response.write(' > </TD>');

	    Response.write('<TD>'+RS('Course')+'</td>');
	    Response.write('<TD>'+RS('Day')+'</td>');
	    Response.write('<TD>'+RS('Time')+'</td>');
	    Response.write('<TD>'+RS('Instructor')+'</td>');
	    
	    Response.write('</TR>');
        RS.MoveNext();
    }
	Response.write('</Table>');
    Response.write('<BR><BR><BR><BR><input type="submit" value="تاييد" name="B1" >');
    Response.write('</Form>');       	  
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');


          Response.write('</Div>');
	RS.Close();
	CloseConnection();
}
//---------------------------------------------------------------------------------------------------------------------
function CourseStudent(){
          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');

    Response.write('<td valign="top" align ="right" >');
    Response.write('<p align=right><font color="#374c28"><a href="Register.asp?State=MainMenu" class="new_a">بازگشت به صفحه ثبت نام</a><p><br>');

	var TermID=ReadArgNotNull("TermID","Null");
	var TermCourseID = ReadArgNotNull("TermCourseID","Null")

	CreateDBGrid(
		"Declare @TermCourseID as int"+CRLF+
		"Set @TermCourseID = "+TermCourseID+CRLF+
		"Declare @TermID as int"+CRLF+
		"Set @TermID = "+TermID+CRLF+
		"if(@TermID is null) Select @TermID = TermID from T_EL_TermCourse where @TermCourseID=ID"+CRLF+
	    "Select 'ليست کاربران ثبت نام شده '+(Select Cast(Vlu as varchar) from T_EL_DFN where ID=@TermID )+Isnull((Select '-'+Cast(Vlu as varchar) from T_EL_DFN where ID=(Select CourseID from T_EL_TermCourse where @TermCourseID=ID)),'')",

		"Declare @TermCourseID as int"+CRLF+
		"Set @TermCourseID = "+TermCourseID+CRLF+
		"Declare @TermID as int"+CRLF+
		"Set @TermID = "+TermID+CRLF+
		"Declare @LoginUserID as int"+CRLF+
		"Set @LoginUserID = "+LoginUserID+CRLF+

		"if(@TermID is null) Select @TermID = TermID from T_EL_TermCourse where @TermCourseID=ID"+CRLF+
		"SELECT "+CRLF+
		"'<a href=Register.asp?State=ShowProfile&UserID='+Cast(StudentID as varchar)+'>'+(Select UserName from T_CMN_Person where StudentID=ID) +'</a>',"+CRLF+
		"'<a href=Register.asp?State=Status&UserID='+Cast(StudentID as varchar)+'&TermID='+Cast(@TermID as varchar)+'>ترم جاري</a>'+(Select '' from T_EL_TermCourse where ID=@TermCourseID and InstructorID=@LoginUserID),"+CRLF+
		"'<a href=Register.asp?State=Status&UserID='+Cast(StudentID as varchar)+'>کلي</a>'+(Select '' from T_EL_TermCourse where ID=@TermCourseID and InstructorID=@LoginUserID) "+CRLF+
		"FROM "+CRLF+
		"T_EL_TermCourseStudent "+CRLF+
		"Where "+CRLF+
		"(TermCourseID in (Select ID from T_EL_TermCourse where TermID = @TermID and @TermCourseID is null)) or TermCourseID = @TermCourseID"+CRLF+
		"GROUP BY StudentID "+CRLF,
 
		["<font color=#003399>نام</font>","<font color=#003399>وضعيت ترم جاري</font>","<font color=#003399>وضعيت كلي </font>"],
		"#6699ff",30,"","350",30);

          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');


          Response.write('</Div>');
}
//---------------------------------------------------------------------------------------------------------------------
function Terms(){
          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');

    Response.write('<td valign="top" align ="right" >');
    Response.write('<p align=right><a href="Register.asp?State=MainMenu" class="new_a">بازگشت به صفحه ثبت نام</a><p><br>');

	CreateDBGrid("Select 'ليست ترمها'",
		"Declare @PID as int Select @PID = dbo.fn_EL_Dfn_GetID (Null , 'EL\\Terms')"+CRLF+
		"SELECT "+CRLF+
		"Vlu ,"+CRLF+
		"'<a href=Register.asp?State=CourseStudent&TermID='+Cast(ID as varchar) +'>ليست کاربران</a>',"+CRLF+
		"'<a href=Register.asp?State=Course&TermID='++Cast(ID as varchar) +'>دروس ارائه شده</a>'"+CRLF+
		"FROM T_EL_DFN "+CRLF+
		"where PID = @PID "+CRLF+
		"ORDER BY id DESC"+CRLF,
 
		["<font color=#003399>نام ترم</font>","<font color=#003399>ليست کاربران</font>","<font color=#003399>دروس ارائه شده</font>"],
		"#6699ff",30,"","350",30);

    Response.write('<hr><P  align=Center><a href="Register.asp?State=TermEntry"  class="new_a">ترم جديد </a>');
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');


          Response.write('</Div>');
}
//---------------------------------------------------------------------------------------------------------------------
function TermEntry(){
	OpenConnection() 
    var RS=Server.CreateObject("ADODB.RecordSet")
	var TermID=ReadArg("TermID","");
	var TermName=ReadArg("TermName");
	
	if (!IsNull(TermName)){
          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');

	    Response.write('<td valign="top" align ="right" dir=rtl>');
		if (IsNull(TermID))
     		Conn.Execute (
		    "Declare @PID as int Select @PID = dbo.fn_EL_Dfn_GetID (Null , 'EL\\Terms')"+CRLF+
     		"Insert into T_EL_DFN (ID,PID,Vlu) Select (Select MAX(ID)+1 from T_EL_DFN where PID =@PID),@PID,'" +TermName+ "'",'',1);
		else Conn.Execute ("Update T_EL_DFN Set Vlu='" +TermName+ "' where ID="+TermID,'',1);

        Response.write('<p align=right>ترم ثبت شد.<p><br><br><br>');
        Response.write('<p align=right><a href="Register.asp?State=MainMenu" class="new_a">بازگشت به صفحه ثبت نام</a><p><br><br><br>');
		CloseConnection();
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');


          Response.write('</Div>');
		return;
	}
    
	if (!IsNull(TermID))
	{
		RS.open( 'Select Vlu from T_EL_DFN where ID='+TermID , Conn, 1, 1);
		TermName=RS('Vlu').value;
		RS.Close();
	}
	else TermName='';

          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');

    Response.write('<td valign="top" align ="right" dir=rtl>');
    Response.write('<FORM action="Register.asp?State=TermEntry&TermID='+TermID+'" method="post" name="myform"  >');          
    Response.write('<P align=center>');
    Response.write('نام ترم');
    Response.write('<INPUT maxLength=200 name=TermName dir=ltr Required=true Value="'+TermName+'" LANGUAGE=javascript onkeypress="return FARKeyPress()">');
    Response.write('<BR><BR><BR><BR><input type="submit" value="تاييد" name="B1" >');
    Response.write('</P>');
    Response.write('</Form>');       	  
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');


          Response.write('</Div>');
    
	CloseConnection();
}    


//---------------------------------------------------------------------------------------------------------------------
function SelectTermCourseSession(){
	OpenConnection() 
	var TermID=ReadArg("TermID"); 
    var UserId=ReadArg("UserId",LoginUserID);
    var RS=Server.CreateObject("ADODB.RecordSet")
    RS.open(
		"Declare @StudentID as int" + CRLF +
		"Set @StudentID = "+UserId + CRLF +
		"Declare @TermID as int" + CRLF +
		"Set @TermID = "+TermID + CRLF +

		"Select TCS.Id , cast(TCS.TermCourseID as varchar)+ (Select Vlu from T_EL_DFN where ID = (Select CourseID from T_EL_TermCourse where ID= TCS.TermCourseID))+ ' جلسه '+Cast(TCS.SessionNo as varchar) as Vlu" + CRLF +
		"from T_EL_TermCourseSession TCS," + CRLF +
		"(" + CRLF +
		"Select TermCourseID, Min(SessionNo)SessionNo" + CRLF +
		"from T_EL_TermCourseSession TCS" + CRLF +
		"where " + CRLF +
		"TCS.TermCourseID in (Select ID from T_EL_TermCourse where TermID=@TermID) AND  " + CRLF +
		"TCS.TermCourseID in (Select TermCourseID from T_EL_TermCourseStudent where StudentID=@StudentID) AND " + CRLF +
		"TCS.ID not in (Select TermCourseSessionID from T_EL_TermCourseStudentAnswer where TermCourseStudentID=(Select ID from T_EL_TermCourseStudent where TCS.TermCourseID = TermCourseID AND StudentID=@StudentID ))" + CRLF +
		"Group By TermCourseID)A" + CRLF +
		"Where TCS.TermCourseID = A.TermCourseID AND TCS.SessionNo = A.SessionNo" ,Conn,1,1);
          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');

    Response.write('<td valign="top" align ="right" dir=rtl>');
    Response.write('<div dir=rtl>');
    Response.write('<p align=right><a href="Register.asp?State=MainMenu" class="new_a">بازگشت به صفحه ثبت نام</a><p><br><br><br>');
    
	if(!RS.EOF)
	{
		Response.write('<FORM action="Register.asp?State=Exam" method="post" name="myform">');
	    Response.write('<p>');
		Response.write('<table border="0" cellspacing="0" cellpadding="0" align="Center">');
		Response.write('<tr>');
		Response.write('<td height=30 width=150 align="Center" bgcolor="#6699ff"><font color="#003399">نام درس  </font></a></td>');
		Response.write('<td height=30 width=150 align="Center"><select size="1" name="TermCourseSessionID">');
		while(!RS.EOF ){
			    Response.write('<option value="'+RS("ID")+'">'+RS("Vlu")+'</option>');
				RS.MoveNext();}
	    Response.write('</td>');
		Response.write('</tr>');

		Response.write('<tr><td height=30 width=150 align="Left" ><input type="submit" value="تاييد" name="B1" ></td></tr>');
		Response.write('</table></p></form>');
	}
	else Response.write('جلسه اي براي امتحان وجود ندارد');
	
	Response.write('</div>');
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');


          Response.write('</Div>');

    RS.Close();
	CloseConnection();
}
//---------------------------------------------------------------------------------------------------------------------
function ExamClientFunction(){

	if(ExamClientFunctionFlag){
	Response.write('var j=0;');
	Response.write('function Timer(){');
	Response.write('	myform.lTimer.value=Sec2Str(j++);');
	
	//Response.write('	lTimer.alt=Sec2Str(j++);');
	Response.write('	setTimeout("Timer()", 1000);  ');
	Response.write('}');
}
	Response.write('function window_onload() {');
	if(ExamClientFunctionFlag){
	Response.write('Timer();');
	}
	Response.write('}');
}
function Exam(){
    ExamClientFunctionFlag=0;
	OpenConnection() 
    var RS=Server.CreateObject("ADODB.RecordSet")
          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');

    Response.write('<td valign="top" align ="Center">');

	var TermCourseSessionID=ReadArg("TermCourseSessionID"); 

    RS.open('Select TermCourseID from T_EL_TermCourseSession where ID ='+TermCourseSessionID,Conn,1,1);
	TermCourseID = RS('TermCourseID').value;
    RS.close();
	
    UserId=ReadArg("UserId",LoginUserID);
    
    RS.open('Select ID from T_EL_TermCourseStudent where TermCourseID='+TermCourseID+' and StudentID='+UserId,Conn,1,1);
    if(RS.RecordCount==0 )
    {
		Response.write('شما در اين ترم ثبت نام نکرديد');
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');


          Response.write('</Div>');
		return;		
    }
    TermCourseStudentID=RS("ID").value;
    RS.close();
    
    RS.open("Select ID from T_EL_TermCourseStudentAnswer where TermCourseStudentID="+TermCourseStudentID+' and TermCourseSessionID='+TermCourseSessionID,Conn,1,1);
    if(RS.RecordCount!=0 )
    {
		Response.write('شما قبلا امتحان داديد');
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');


          Response.write('</Div>');
		return;		
    }
    RS.close();

	RS.open("Select cast(TCS.TermCourseID as varchar)+ (Select Vlu from T_EL_DFN where ID = (Select CourseID from T_EL_TermCourse where ID= TCS.TermCourseID))+ ' جلسه '+Cast(TCS.SessionNo as varchar) as Vlu from T_EL_TermCourseSession TCS" ,Conn,1,1);
	var Title = RS('Vlu').value;
    RS.close();

    RS.open("Select Cast(DatePart(yyyy,GetDate()) as varchar) + '/' + Right('0'+Cast( DatePart(mm,GetDate()) as varchar),2) + '/' + Right('0'+Cast( DatePart(dd,GetDate()) as varchar),2) as d,Cast(DatePart(hh,GetDate()) as varchar) + ':' + Cast( DatePart(minute,GetDate()) as varchar) + ':' + Cast( DatePart(ss,GetDate()) as varchar) as t",Conn,1,1);
	Conn.Execute ("Insert into T_EL_TermCourseStudentAnswer (TermCourseStudentID,TermCourseSessionID,StartDate,StartTime) Values ("+TermCourseStudentID+","+TermCourseSessionID+",'"+Hejri(RS('D').value)+"','"+RS('T').value+ "')",'',1);

    RS.close();

	RS.open("SELECT ID, Qustion, Answer1, Answer2, Answer3, Answer4 FROM T_EL_TermCourseSessionQuestion WHERE TermCourseSessionID = "+TermCourseSessionID,Conn,1,1);


    Response.write('<div dir=rtl>');
    Response.write('<p align=right><a href="Register.asp?State=MainMenu" class="new_a">بازگشت به صفحه ثبت نام</a><p><br><br><br>');

    Response.write('<table border="0" cellspacing="0" cellpadding="0" align="Center">');
    Response.write('<tr>');
	Response.write('<td height=30 width=500 bgcolor="#6699ff" align="Center"><font color="#003399">سوالات درس '+Title+'</font></a></td>');
    Response.write('</tr>');
    Response.write('</table>');

    Session('TermCourseSessionID')=TermCourseSessionID
    Response.write('<FORM action="Register.asp?State=ExamAnswered" method="post" name="myform">');
    Response.write('<Input  name="lTimer" style="width=60" MaxLength=10 value="0" ReadOnly="TRUE">');
    Response.write('<p>');
    Response.write('<table border="0" cellspacing="0" cellpadding="0" align="Center">');
    var I=0;
    while(!RS.EOF ){
		I++;
        Response.write('<tr><td height=30 width=500 align=Right ><font color="#FF0080">'+I+'-'+RS("Qustion").Value+'</font></a></td></tr>');
        Response.write('<tr><td height=30 width=500 align=Right ><font color="#000080"><input type="radio" value="1" name="R'+RS('ID')+'">'+RS("Answer1")+'</font></a></td></tr>');
        Response.write('<tr><td height=30 width=500 align=Right ><font color="#000080"><input type="radio" value="2" name="R'+RS('ID')+'">'+RS("Answer2")+'</font></a></td></tr>');
        Response.write('<tr><td height=30 width=500 align=Right ><font color="#000080"><input type="radio" value="3" name="R'+RS('ID')+'">'+RS("Answer3")+'</font></a></td></tr>');
        Response.write('<tr><td height=30 width=500 align=Right ><font color="#000080"><input type="radio" value="4" name="R'+RS('ID')+'">'+RS("Answer4")+'</font></a></td></tr>');
        Response.write('<tr><td height=30 width=500 align=Center> -------------------------------------------------------------- </font></a></td></tr>');
		RS.MoveNext();}              

    Response.write('<tr><td height=30 width=500 bgcolor="#6699ff" align="Center"><font color="#003399">پايان سوالات </font></a></td></tr>');
    Response.write('<tr><td height=30 width=500 align="Center" ><input type="submit" value="تاييد" name="B1" ></td></tr>');
    Response.write('</table></p></form></div>');
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');


          Response.write('</Div>');

    RS.Close();
	CloseConnection();
	ExamClientFunctionFlag=1;
}
//---------------------------------------------------------------------------------------------------------------------
function ExamAnswered(){
	OpenConnection() 
    var RS=Server.CreateObject("ADODB.RecordSet")

	var lTimer=ReadArg("lTimer"); 

	var TermCourseSessionID=ReadArg("TermCourseSessionID"); 

    RS.open('Select TermCourseID from T_EL_TermCourseSession where ID ='+TermCourseSessionID,Conn,1,1);
	TermCourseID = RS('TermCourseID').value;
    RS.close();
	
    var UserId=ReadArg("UserId",LoginUserID);
    
    RS.open('Select ID from T_EL_TermCourseStudent where TermCourseID='+TermCourseID+' and StudentID='+UserId,Conn,1,1);
          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');

    Response.write('<td valign="top" align ="right" dir=rtl>');
    if(RS.RecordCount==0 )
    {
		Response.write('شما در اين ترم ثبت نام نکرديد');
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');


          Response.write('</Div>');
		return;		
    }
    TermCourseStudentID=RS("ID").value;
    RS.close();

    RS.open("Select ID from T_EL_TermCourseStudentAnswer where TermCourseStudentID="+TermCourseStudentID+' and TermCourseSessionID='+TermCourseSessionID,Conn,1,1);
    if(RS.RecordCount==0 )
    {
		Response.write('رکورد اصلي جواب وجود ندارد');
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');


          Response.write('</Div>');
		return;		
    }
    TermCourseStudentAnswerID=RS("ID").value;
    RS.close();

	RS.open("SELECT ID, CorrectAnswer FROM T_EL_TermCourseSessionQuestion WHERE TermCourseSessionID="+TermCourseSessionID,Conn,1,1);
	var T=0;F=0;
    while(!RS.EOF ){
    	if (ReadArg('R'+RS('ID')) == RS('CorrectAnswer')) {T++;V=1;}
		else {F++;V=0;}
      	Conn.Execute ("Insert into T_EL_TermCourseStudentAnswerDetail (TermCourseStudentAnswerID,QuestionID,AnswerNo,Grade) Values ("+TermCourseStudentAnswerID+","+RS('ID')+","+ReadArgNotNull('R'+RS('ID'),"''")+","+V+ ")",'',1);
		RS.MoveNext();}              
    RS.Close();
   	Conn.Execute ("Update  T_EL_TermCourseStudentAnswer Set AnswerTime='"+lTimer+"',Grade="+T*100/(T+F)+" where ID = "+TermCourseStudentAnswerID,'',1);
	CloseConnection();
	
    Response.write('<div dir=rtl>');
    Response.write('<p align=right><a href="Register.asp?State=MainMenu" class="new_a">بازگشت به صفحه ثبت نام</a><p><br><br><br>');
    Response.write('<Table align=center bgcolor="#66FFff">');
    Response.write('<TR><TD>زمان پاسخگوئي</TD><TD>'+lTimer+'</TD></TR>');
    Response.write('<TR><TD>جواب هاي صحيح</TD><TD>'+T+'</TD></TR>');
    Response.write('<TR><TD>جواب هاي غلط</TD><TD>'+F+'</TD></TR>');

    Response.write('</Table>');

    Response.write('<table border="0" cellspacing="0" cellpadding="0" align="Center">');
    Response.write('<tr><td height=30 width=500 bgcolor="#6699ff" align="Center"><font color="#003399">با آرزوي موفقيت در امتحان</font></a></td></tr>');
    Response.write('</table></div>');
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');


          Response.write('</Div>');
}
//---------------------------------------------------------------------------------------------------------------------
function Status(){
    var UserID=ReadArg("UserID"); var TermID = ReadArgNotNull("TermID","Null")

          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');

    Response.write('<td valign="top" align ="right" >');
    Response.write('<p align=right><a href="Register.asp?State=MainMenu" class="new_a">بازگشت به صفحه ثبت نام</a><p><br>');

	CreateDBGrid(
		"Declare @UserID as int"+CRLF+
		"Set @UserID="+UserID+CRLF+
		"Declare @TermID as int"+CRLF+
		"Set @TermID = "+TermID+CRLF+

		"Select '<a href=Register.asp?State=ShowProfile&UserId='+cast(@UserID as varchar)+'> '+(Select UserName from T_CMN_Person where ID=@UserID)+'</a> ليست درسهاي  '+IsNull((Select Vlu as TermName from T_EL_DFN where ID=@TermID),'')"+CRLF,
		"Declare @TermID as int"+CRLF+
		"Set @TermID = "+TermID+CRLF+
		"Declare @UserID as int"+CRLF+
		"Set @UserID = "+UserID+CRLF+
		"SELECT "+CRLF+
		"TermCourseID, IsNull(Cast(Grade as varchar), '-'),"+CRLF+
		"'<a href=Register.asp?State=StatusQuiz&TermCourseID='+cast(TermCourseID as varchar)+'&UserID='+Cast(@UserID as varchar)+'>امتحانات</a>'"+CRLF+
		"FROM  T_EL_TermCourseStudent "+CRLF+
		"WHERE "+CRLF+
		"TermCourseID in (Select ID from T_EL_TermCourse where TermID = @TermID or @TermID is Null)"+CRLF+
		"AND StudentID="+UserID+CRLF,

		["<font color=#003399>کد درس</font>","<font color=#003399>نمره</font>","<font color=#003399>امتحانات</font>"],
		"#6699ff",30,"","350",30);

          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');


          Response.write('</Div>');
}
//---------------------------------------------------------------------------------------------------------------------
function StatusQuiz(){
    var UserID=ReadArg("UserID"); var TermCourseID = ReadArgNotNull("TermCourseID","Null")

          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');

    Response.write('<td valign="top" align ="right" >');
    Response.write('<p align=right><a href="Register.asp?State=MainMenu" class="new_a">بازگشت به صفحه ثبت نام</a><p><br><br><br>');

	CreateDBGrid(
		"Declare @UserID as int"+CRLF+
		"Set @UserID="+UserID+CRLF+
		"Declare @TermCourseID as int"+CRLF+
		"Set @TermCourseID = "+TermCourseID+CRLF+

		"Select 'امتحانات '+'<a href=Register.asp?State=ShowProfile&UserId='+cast(@UserID as varchar)+'> '+(Select UserName from T_CMN_Person where ID=@UserID)+'</a>'+' - درس '+"+CRLF+
		"(Select Vlu from T_EL_DFN where ID=(Select CourseID from T_EL_TermCourse where ID=@TermCourseID))+' - '+"+CRLF+
		"(Select Vlu from T_EL_DFN where ID=(Select TermID from T_EL_TermCourse where ID=@TermCourseID))"+CRLF,
		
		"Declare @TermCourseID as int"+CRLF+
		"Set @TermCourseID = "+TermCourseID+CRLF+
		"Declare @UserID as int"+CRLF+
		"Set @UserID = "+UserID+CRLF+
		
		"Select "+CRLF+
		"'<a href=Register.asp?State=StatusQuizDetail&TermCourseStudentAnswerID='+cast(ID as varchar)+'>'+(Select cast(SessionNo as varchar) from T_EL_TermCourseSession where ID = TermCourseSessionID) +'</a>', '<div dir=ltr align=right>'+StartDate+'</div>', StartTime ,AnswerTime, IsNull(Cast(Grade as varchar),'-')"+CRLF+
		"from T_EL_TermCourseStudentAnswer"+CRLF+
		"where TermCourseStudentID = (Select ID from T_EL_TermCourseStudent where TermCourseID = @TermCourseID and StudentID = @UserID)"+CRLF,

		["<font color=#003399> جلسه </font>","<font color=#003399>تاريخ</font>","<font color=#003399>ساعت</font>","<font color=#003399>مدت پاسخگوئي</font>","<font color=#003399>نمره از 100</font>"],
		"#6699ff",30,"#ECF4FB","350",30);


          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');
          Response.write('</Div>');
}
//---------------------------------------------------------------------------------------------------------------------
function StatusQuizDetail(){
    var UserID=ReadArg("UserID"); var TermCourseStudentAnswerID = ReadArgNotNull("TermCourseStudentAnswerID","Null")

          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');

    Response.write('<td valign="top" align ="right" >');
    Response.write('<p align=right><a href="Register.asp?State=MainMenu" class="new_a">بازگشت به صفحه ثبت نام</a><p><br><br><br>');
	OpenConnection();
    var RS=Server.CreateObject("ADODB.RecordSet")
    RS.open(
		"Declare @TermCourseStudentAnswerID as int"+CRLF+
		"Set @TermCourseStudentAnswerID = "+TermCourseStudentAnswerID+CRLF+

		"Select "+CRLF+
		"'<a href=Register.asp?State=ShowProfile&UserId=' + Cast(T_CMN_Person.ID as varchar)+'>'+UserName +'</a>'+"+CRLF+
		"(Select (Select (Select Vlu from T_EL_DFN where ID=TermID)+'-'+(Select Vlu from T_EL_DFN where ID=CourseID) from T_EL_TermCourse where ID=TermCourseID)+' - جلسه '+Cast(SessionNo as varchar)from T_EL_TermCourseSession where ID=TermCourseSessionID)"+CRLF+
		"from T_CMN_Person , T_EL_TermCourseStudentAnswer"+CRLF+
		"where T_EL_TermCourseStudentAnswer.ID = @TermCourseStudentAnswerID AND"+CRLF+
		"T_CMN_Person.ID=(Select StudentID from T_EL_TermCourseStudent where ID=TermCourseStudentID)"+CRLF
    ,Conn,1,1);


    Response.write('<p align=center dir=rtl>'+RS(0)+'</p>');
	RS.Close();
    RS.open(
	
		"Declare @TermCourseStudentAnswerID as int"+CRLF+
		"Set @TermCourseStudentAnswerID = "+TermCourseStudentAnswerID+CRLF+

		"Select "+CRLF+
		"Qustion ,CorrectAnswer,AnswerNo,"+CRLF+
		"Answer1 ,Answer2 ,Answer3 ,Answer4 "+CRLF+
		"from T_EL_TermCourseStudentAnswerDetail , T_EL_TermCourseSessionQuestion"+CRLF+
		"where TermCourseStudentAnswerID = @TermCourseStudentAnswerID And"+CRLF+
		"T_EL_TermCourseSessionQuestion.ID = QuestionID"+CRLF

    ,Conn,1,1);
    var I=0;
    Response.write('<table border="0" cellspacing="0" cellpadding="0" valign="Top" align="Center" dir=rtl>');
    while(!RS.EOF ){I++;
		Response.write('<TR><TD>'+I+' - <font color="#FF0080">'+RS(0)+'</font></TD></TR>');		
    	for(J=1;J<=4;J++){
    		Response.write('<TR><TD>');
			if (RS('CorrectAnswer')==J)   	Response.write('<Img Src=Images/CorrectAnswer.gif>');
			if (RS('AnswerNo')==J)   	Response.write('<Img Src=IMages/UserAnswer.gif>');
    	    Response.write(RS('Answer'+J));		
    		Response.write('</TR></TD>');
    	}    
  		Response.write('<TR><TD height=30>');
   		Response.write('</TR></TD>');
        RS.MoveNext();
    }
    Response.write('</Table>');
    RS.Close();          
    Conn.Close();
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');

          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');
          Response.write('</Div>');
}
//---------------------------------------------------------------------------------------------------------------------
function SelectTermContent(){
    var SearchWords=ReadArg("SearchWords");
    SearchWords=Trim(SearchWords);
    Session('SearchWords')=SearchWords

	var TermCourse=ReadArg("TermCourse");
    Session('TermCourse')=TermCourse
    
          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');




          Response.write('</tr>');
          Response.write('<tr>');

    Response.write('<td valign="top" align ="right" dir=rtl>');
    if (SearchWords!=null && SearchWords!=''){
    var SearchWordsWhere = CorrectSearchWords(SearchWords);
	CreateDBGrid(

		"Select '"+SearchWordsWhere+"' ",
		
		"SELECT '<a href=Register.asp?State=ShowFile&FileName='+Path+'>'+Isnull(DocTitle,'-')+'</a>'"+CRLF+
		"FROM OpenQuery(ELCONTENT, "+CRLF+
		"               'SELECT DocTitle , Path"+CRLF+
		"                FROM "+'"'+IndexServerName+'".'+"ELCONTENT..SCOPE() where Contains( Contents , ''"+SearchWordsWhere+"'') and path like ''%"+TermCourse+"%'' '"+CRLF+
		"              ) ORDER BY PATH"+CRLF,


		["<font color=#003399>عنوان</font>"],
		"#6699ff",30,"","350",30);
    }
	else
	CreateDBTree(
        "Declare @UserID as int "+CRLF+
		"Set @UserID = "+ReadArg("UserId",LoginUserID)+CRLF+

		"Select Cast(TC.ID as varchar) ID, "+CRLF+
		"       Null as PID , "+CRLF+
		"       (Select Vlu from T_EL_DFN where ID=TC.CourseID) as Title"+CRLF+
		"from T_EL_TermCourse TC "+CRLF+
		"where (ID in (Select TermCourseID from T_EL_TermCourseStudent where StudentID=@UserID)) or InstructorID=@UserId"+CRLF+

		"Union "+CRLF+
		"Select Left(Cast(TermCourseID as varchar)+'000000',5) + Cast(SessionNo as varchar)ID , "+CRLF+
		"       Cast(TermCourseID as varchar) as PID,"+CRLF+
		"       ' جلسه '+Cast(SessionNo as varchar) as Title "+CRLF+
		"from T_EL_TermCourseSession"+CRLF+
		"where TermCourseID in (Select TermCourseID from T_EL_TermCourseStudent where StudentID=@UserID) or"+CRLF+
		"      TermCourseID in (Select ID from T_EL_TermCourse where InstructorID=@UserID) "+CRLF+
		"Union "+CRLF+

		//"SELECT '<a href=Register.asp?State=ShowFile&FileName='+Path+'>'+Isnull(DocTitle,'-')+'</a>'"+CRLF+

		"Select Left(Cast(TCS.TermCourseID as varchar)+'000000',5) +Left(Cast(TCS.SessionNo as varchar)+'000000',5) +right('000'+Cast(TCSC.ID as varchar),4) ID, "+CRLF+
		"       Left(Cast(TCS.TermCourseID as varchar)+'000000',5)+ Cast(SessionNo as varchar)  PID ,"+CRLF+
		"       '<a target=_blank  Href=Register.asp?State=ShowFile&FileName=E:\\Content\\Data\\Content\\'+Cast(TCS.TermCourseID as varchar)+'\\'+Right('0'+Cast(TCS.SessionNo as varchar),2)+'\\'+TCSC.FileName+'.html>'+TCSC.Title +'</a>'"+CRLF+
		"from T_EL_TermCourseSession TCS, T_EL_TermCourseSessionContent TCSC"+CRLF+
		"where TCS.ID = TCSC.TermCourseSessionID AND"+CRLF+
		"(TCS.TermCourseID  in (Select TermCourseID from T_EL_TermCourseStudent where StudentID=@UserID) or "+CRLF+
		" TCS.TermCourseID in (Select ID from T_EL_TermCourse where InstructorID=@UserID))"+CRLF+
		"order By ID"+CRLF
	
	);
    Response.write('</td>');

    Response.write('<td valign="top" align ="right" dir=rtl>');
/////////////////////////////////////
// بخش جستجو در اینجا حذف شد، چون درست کار نمی کرد
/*    Response.write('<FORM action="Register.asp?State=SelectTermContent" method="post" name="myform">');          
    CreateRadioGroup('TermCourse','true','',
        "Declare @UserID as int "+CRLF+
		"Set @UserID = "+ReadArg("UserId",LoginUserID)+CRLF+

		"Select Cast(TC.ID as varchar) ID, "+CRLF+
		"       (Select Vlu from T_EL_DFN where ID=TC.CourseID) as Vlu"+CRLF+
		"from T_EL_TermCourse TC "+CRLF+
		"where (ID in (Select TermCourseID from T_EL_TermCourseStudent where StudentID=@UserID)) or InstructorID=@UserId"+CRLF,
		TermCourse
    ) 	

    Response.write('<BR>'+'جستجو'+'<BR>');
    Response.write('<INPUT maxLength=20 name=SearchWords dir=rtl Required=true Value="'+IsNullThenDef(SearchWords,'')+'" LANGUAGE=javascript onkeypress="return FARKeyPress()">');
    Response.write('<br>');
    Response.write('<input type="submit" value="جستجو" name="B1" >');
    Response.write('</FORM>');          
*/
/////////////////////////////////////
          Response.write('</TD>');
          Response.write('</TR>');
          Response.write('<tr>');

          Response.write('</tr>');

          Response.write('</Table>');
          Response.write('</Div>');
}
//---------------------------------------------------------------------------------------------------------------------
function Library(){
          Response.write('<div align="center">');
          Response.write('<table border="0" width=200 cellspacing="0" cellpadding="0">');
          Response.write('<tr>');
//          Response.write('  <td><img border="0" src="../Images/HeaderMain.gif" ></td>');
//          Response.write('  <td><a href="Register.asp"><img border="0" src="../Images/ArmMain.gif" ></a></td>');
          Response.write('</tr>');
          Response.write('<tr>');
    Response.write('<td valign="top" align ="right" dir=rtl>');
    Response.write('<FORM action="Register.asp?State=LibraryBook" method="post" name="myform">');          
	CreateDBGrid(

		"Select 'ليست کتابها' ",
		
		"SELECT '<a href=Register.asp?State=LibraryBook&BookID='+Cast(ID as varchar)+'>'+Title+'</a>'"+CRLF+
		"FROM T_EL_Libraray where pid is null",

		["<font color=#003399>عنوان کتابها</font>"],
		"#6699ff",30,"#ECF4FB","50%",30);
    
	
          Response.write('</TD></TR></Table>');
          Response.write('</Div>');
}
function LibraryBook(){
    var SearchWords=ReadArg("SearchWords");
    SearchWords=Trim(SearchWords);
    Session('SearchWords')=SearchWords

	var BookID=ReadArg("BookID");
    Session('BookID')=BookID

          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding="0">');
          Response.write('<tr>');
          Response.write('  <td><img border="0" src="../Images/HeaderMain.gif" ></td>');
          Response.write('  <td><a href="Register.asp"><img border="0" src="../Images/ArmMain.gif" ></a></td>');
          Response.write('</tr>');
          Response.write('<tr>');
	OpenConnection()
    var RS=Server.CreateObject("ADODB.RecordSet");
    RS.open( 'Select Title from T_EL_Libraray where ID='+BookID , Conn, 1, 1);
    Response.write('<td valign="top" align ="right" dir=rtl>');
	Response.write(RS("Title"))
    RS.Close();
    if (SearchWords!=null && SearchWords!=''){
    var SearchWordsWhere = CorrectSearchWords(SearchWords);
	CreateDBGrid(

		"Select '"+SearchWordsWhere+"' ",
		
		"SELECT '<a href=Register.asp?State=ShowFile&FileName='+Path+'>'+Isnull(DocTitle,'-')+'</a>'"+CRLF+
		"FROM OpenQuery(ELLIBRARY, "+CRLF+
		"               'SELECT DocTitle , Path"+CRLF+
		"                FROM "+'"'+IndexServerName+'".'+"ELLIBRARY..SCOPE() where Contains( Contents , ''"+SearchWordsWhere+"'')'"+CRLF+
		"              ) ORDER BY PATH"+CRLF,


		["<font color=#003399>عنوان</font>"],
		"#6699ff",30,"#003399","50%",30);
    }
    else
	CreateDBTree(
        "Declare @BookID as int "+CRLF+
		"Set @BookID = "+BookID+CRLF+
		"Select ID , PID , case when C_ID<>0 then Title else '<a  Href =Register.asp?State=ShowFile&FileName=E:\\Content\\Data\\LIBRARY\\'+Cast(@BookID as varchar)+'\\'+Cast(FromPage as varchar)+'.html>'+Title+'</a>' end as Title"+CRLF+
		"from ("+CRLF+
		"Select ID,(Select Count(ID) from T_EL_Libraray T where T.PID = T_EL_Libraray.ID)C_ID,Case when PID = @BookID then null else PID end as PID,Title,FromPage "+CRLF+
		"from T_EL_Libraray where PID like '%'+Cast(@BookID as varchar)+'%')a"+CRLF
	
	);
    Response.write('</TD>')
    Response.write('<td valign="top" align ="right" dir=rtl>');
    Response.write('<FORM action="Register.asp?State=LibraryBook" method="post" name="myform">');          
    Response.write('جستجو'+'<BR>');
    Response.write('<INPUT maxLength=20 name=SearchWords dir=rtl Required=true Value="'+IsNullThenDef(SearchWords,'')+'" LANGUAGE=javascript onkeypress="return FARKeyPress()">');
    Response.write('<BR>');
    Response.write('<input type="submit" value="جستجو" name="B1" >');
    Response.write('</FORM>');          
          Response.write('</TD></TR></Table>');
          Response.write('</Div>');
	CloseConnection();
}
//---------------------------------------------------------------------------------------------------------------------
 function ShowFile(){
var FileObject, InStream, ForReading,S;

var FileName=ReadArg("FileName");
var SearchWords=ReadArg("SearchWords");
    Session('SearchWords')=SearchWords

    var ssSearchWordsWhere =""
    if (SearchWords!=null && SearchWords!="") ssSearchWordsWhere = CorrectSearchWordsForSplit(SearchWords).split(' ');

	FileObject = Server.CreateObject("Scripting.FileSystemObject")
	//FileObject = new ActiveXObject("Scripting.FileSystemObject")
	InStream= FileObject.OpenTextFile (FileName,1,false,false)

	S =  InStream.ReadAll()
	S = S.substring(S.indexOf('<body>')+6,S.indexOf('</body>')-1)
	for(I=0;I<ssSearchWordsWhere.length;I++)
	{
	S=replaceall(S,ssSearchWordsWhere[I],'<Font color=#FF0000>'+ssSearchWordsWhere[I]+'</font>')
	}
	
          Response.write('<div align="center">');
          Response.write('<table border="0"  cellspacing="0" cellpadding=0');
          Response.write('<tr>');
          Response.write('</tr>');

          Response.write('<tr>');
          Response.write('<TD  dir =rtl>');
	  Response.write(S);
          Response.write('</TD>');


          Response.write('<td valign="top">&nbsp;</td>');
          Response.write('</TR>');

          Response.write('<tr>');
          Response.write('</tr>');

          Response.write('</Table>');
          Response.write('</Div>');

    InStream.Close();

}
//---------------------------------------------------------------------------------------------------------------------
</script>

<body leftmargin="0" topmargin="0"  <%if (State=="Exam") {%>LANGUAGE=javascript onLoad="return window_onload()"<%}%>>
<!--=================================================================================================================-->
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
								<span><a href="/Ar/">العربية</a></span>
								<span><a href="/DownLoad/">دريافت نرم‌افزار</a>&nbsp;</span>
								<span><a href="/Contact/">ارتباط با‌ما</a>&nbsp;</span>
								<span><a href="/Support/">پشتيبانان</a>&nbsp;</span>
								<span><a href="/News/">تازه‌ها</a>&nbsp;</span>
                                <span><a href="/Poster/">تبلیغات</a>&nbsp;</span>
								<!--<span><a href="javascript:void(0)" onclick="return gotoOldSite()">نسخه قديمي سايت</a></span>-->
							</td>
							</tr>
						</table>
					</div>
					<div class="messenger-area" id="messenger">
					<table class="messengerlink">
					<tr>
					<td class="messengerlink-td1"><a href="http://eshia.ir/feqh/timing/"><img style="border:0px;outline:0px" src="/Images/messenger.gif" /></a></td>
					<td class="messengerlink-td3"></td>
					</tr>
					</table>
						<!--<table class="messenger-table" border="0">
							<tr class="common-view no-connecting-view">
								<td colspan="2" class="messenger-Cpannel">
									<form id="control_panel">
										<span class="messenger-field-back-state messenger-user-state connected-view"></span>
										<span class="messenger-field-back no-connected-view">
											<span id="uid-back" > نام کاربری <input type="text" id="uid" /></span>
											<span id="pwd-back" >کلمه عبور <input type="password" id="pwd" /></span>
											<span id="publog-back">
												<input type="checkbox" id="publog"/>
												<label for="publog" style="vertical-align:top">ورود به صورت کاربر عمومي</label>
											</span>
										</span>
										<span id="select-back" class="messenger-field-back no-connected-view">
											<select></select>
										</span>
										<input type="submit" value="ورود" id="btnLogin" class="dc-view"/>
										<input type="button" value="خروج یا تغییر کاربر" id="btnLogout" class="connected-view"/>
									</form>
								</td>
							</tr>
							<tr class="notsupport initialize_failed-view">
								<td colspan="2" >مرور گر شما از برنامه پیام رسان اینترنتی مدرسه فقاهت  پشتیبانی نمی کند. لطفا از نسخه های جدید تر استفاده بفرمائید.</td>
							</tr>
							<tr class="connecting-panel connecting-view">
								<td colspan="2"  id="connecting-tab">در حال اتصال به شبکه... لطفاً کمی صبر کنید.</td>
							</tr>
							<tr class="connected-view">
								<td class="messenger-show-panel-area">
									<div class="messenger-show-panel">
									</div>
								</td>
								<td rowspan="2" class="messenger-tree-panel">
									<ul id="friends"></ul>
								</td>
							</tr>
							<tr class="connected-view">
								<td class="messenger-send-panel" id="send-panel">
									<form class="form-sendpanel" action="javascript:void(0)">
										<table width="100%" cellspacing="0" cellpadding="0" border="0">
											<tr>
												<td><input type="text" class="send-panel-textarea" style="width:99%"/></td>
												<td width="1px"><input type="submit" value="ارسال" class="send-panel-button"/></td>
											</tr>
										</table>
									</form>
								</td>
							</tr>
							<tr class="login_failed-view" id="login-error">
								<td colspan="2"><span></span></td>
							</tr>
						</table>-->
						
					</div>
		<div id="content">
			<div align="center" class="register-main-div">
			<%			  
			  if(ControlLogin()==1) 			  
			  if (State=="EditProfile") EditProfile()
			  else if (State=="NewProfile") EditProfile()
			  else if (State=="PostProfile") PostProfile()
			  else if (State=="ShowProfile") ShowProfile()
			  
			  else if (State=="List") List()
			  else if (State=="DelList") DelList()
			  
			  else if (State=="Course") Course()
			  else if (State=="CourseEntry") CourseEntry()
			  else if (State=="CourseStudent") CourseStudent()
			  else if (State=="SelectTermCourse") SelectTermCourse()
			  
			  
			  else if (State=="Terms") Terms()
			  else if (State=="TermEntry") TermEntry()

			  else if (State=="SelectTermCourseSession") SelectTermCourseSession()
			  else if (State=="Exam") Exam()
			  else if (State=="ExamAnswered") ExamAnswered()
			  else if (State=="Status") Status()
			  else if (State=="StatusQuiz") StatusQuiz()
			  else if (State=="StatusQuizDetail") StatusQuizDetail()
			  
			  else if (State=="MainMenu") MainMenu()  
			  
			  else if (State=="SelectTermContent") SelectTermContent()
			  else if (State=="Library") Library()
			  else if (State=="LibraryBook") LibraryBook()
			  else if (State=="ShowFile") ShowFile()
			  
			  		  
			  else Login()
			  %>
</div>
<!--#include file="BodyClick.Inc"-->	

					</div>
				</td>
				<td class="rightSection">
					<div id="logo"><img src="/Images/Logo.jpg" width="184" height="215" border="0" usemap="#Map" alt="Logo"/></div>
					<!--//////////end-Serach\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\-->
					<div class="rightmenu">
						<ul class="vmenu fixed-menu">
						  <li class="nomenu">
								<a class="vmenu-title" href="/feqh/">مدرسه فقاهت</a>
								<a href="/feqh/archive/" style="font-size:0.7em; text-indent:1.5em !important;">حوزه علمیه قم-مسجد اعظم</a>
                                <a href="/feqh/archive/qom/ramezan/" style="font-size:0.7em;  text-indent:1.5em !important;">دروس تابستان</a>
								<a href="/Feqh/Archive/qom/" style="font-size:0.7em; text-indent:1.5em !important;">حوزه علمیه قم</a>
                                <a href="/Feqh/Archive/qom/feyzieh/" style="font-size:0.7em; text-indent:1.5em !important;">حوزه علمیه قم - مدرسه فیضیه</a>
								<a href="/Ar/Feqh/Archive/Qom/" style="font-size:0.7em; text-indent:1.5em !important;">حوزه علمیه قم-به زبان عربی</a>
                                <a href="/Feqh/Archive/qom/khan/" style="font-size:0.7em; text-indent:1.5em !important;">حوزه علمیه قم - مدرسه خان</a>
<div class="khat"></div>
								<a href="/Ar/Feqh/Archive/" style="font-size:0.7em; text-indent:1.5em !important;">حوزه علمیه نجف</a>
                                <a href="/Ar/Feqh/Archive/qaravieh/" style="font-size:0.7em; text-indent:1.5em !important;">حوزه علمیه نجف-مدرسه غرویه</a>
                                <a href="/Ar/Feqh/Archive/almasajed/" style="font-size:0.7em; text-indent:1.5em !important;">حوزه علمیه نجف-مساجد</a>
<div class="khat"></div>
								<a href="/Feqh/Archive/Mashhad/" style="font-size:0.7em; text-indent:1.5em !important;">حوزه علمیه مشهد</a>
<div class="khat"></div>
                                <a href="/Ar/Feqh/Archive/Karbala/" style="font-size:0.7em; text-indent:1.5em !important;">حوزه علمیه کربلا</a>
								<a href="/Ar/Feqh/Archive/lebanon/" style="font-size:0.7em; text-indent:1.5em !important;">حوزه علمیه لبنان</a>
                                <a href="/Ar/Feqh/Archive/qatif/" style="font-size:0.7em; text-indent:1.5em !important;">حوزه علمیه قطیف و احساء </a>
                                <a href="/Feqh/Archive/Afghanestan/" style="font-size:0.7em; text-indent:1.5em !important;">حوزه علمیه افغانستان</a>
<div class="khat"></div>
								<a href="/Feqh/Archive/Iran/" style="font-size:0.7em; text-indent:1.5em !important;">حوزه های علمیه شهرستانها</a>
								<a href="/Feqh/Archive/Moaser/" style="font-size:0.7em; text-indent:1.5em !important;">بزرگان معاصر</a>
								<a href="/Feqh/Archive/Subject/" style="font-size:0.7em; text-indent:1.5em !important;">فقه موضوعی</a> 
								<a href="/Aqaed/Archive/" style="font-size:0.7em; text-indent:1.5em !important;">کلام و فلسفه</a>
                                <a href="/Feqh/Archive/Rejal/" style="font-size:0.7em; text-indent:1.5em !important;">رجال</a>
<div class="khat"></div>
                                <a href="/Feqh/Archive/Sayeredoroos/" style="font-size:0.7em; text-indent:1.5em !important;">سایر دروس</a>
<div class="khat"></div>
								<a href="/Ar/Feqh/Archive/Translate/" style="font-size:0.7em; text-indent:1.5em !important;">تقریر عربی درس‌ها</a>
								<hr class="Separator"/>
								<a href="/Feqh/Timing/" style="font-size:0.7em; text-indent:1.5em !important;">زمان درس ها</a>
								<a href="/Feqh/DVD/" style="font-size:0.7em; text-indent:1.5em !important;">لوح فشرده</a>
								<hr class="Separator"/>
                                <a href="http://taqrir.eshia.ir/" style="font-size:0.7em; text-indent:1.5em !important;">تقریر مدرسه فقاهت</a>
                                <a href="/Help/taqrir/" style="font-size:0.7em; text-indent:1.5em !important;">راهنمای تقریر نویسی</a>
                                <hr class="Separator"/>
								<a href="http://lib.eshia.ir" style="font-size:0.7em; text-indent:1.5em !important;">کتابخانه مدرسه فقاهت</a>
								<a href="/help/lib/" style="font-size:0.7em; text-indent:1.5em !important;"> راهنمای کتابخانه مدرسه فقاهت</a>
                                <hr class="Separator"/>
                                <a href="http://www.wikifeqh.ir" style="font-size:0.7em; text-indent:1.5em !important;">ویکی فقه</a>
								<a href="http://www.wikiporsesh.ir" style="font-size:0.7em; text-indent:1.5em !important;">ویکی پرسش</a>
                                
<!--                                <a href="/feqh/archive/exam/92/2/" style="font-size:0.7em; text-indent:1.5em !important;">امتحانات حوزوی</a>-->
								<a href="/android/" class="vmenu-title">نسخه اندروید</a>
                                <a href="/android/" style="font-size:0.7em; text-indent:3em !important;">درباره نسخه اندروید</a>
                                <a href="/help/Android/" style="font-size:0.7em; text-indent:3em !important;">راهنمای نسخه اندروید</a>
                                <a href="/eshia/" class="vmenu-title">پرسشگری دینی</a>
								<a href="/eshia/Timing/" style="font-size:0.7em; text-indent:3em !important;">زمان پاسخگویی</a>
								<a href="/eshia/Mobile/" style="font-size:0.7em; text-indent:3em !important;">نسخه موبایلی</a>
								<a href="/userManual/" class="vmenu-title">راهنمای استفاده</a>
								<a href="/userManual/#Download" style="font-size:0.7em; text-indent:3em !important;">دریافت نرم افزار</a>
								<a href="/userManual/#HowtoTalk" style="font-size:0.7em; text-indent:3em !important;">نحوه گفتگو</a>
								<a href="/userManual/#Chatroom" style="font-size:0.7em; text-indent:3em !important;">تالارها</a>
								<a href="/userManual/#accessory" style="font-size:0.7em; text-indent:3em !important;">امکانات جانبی</a>
								<a href="/userManual/#FAQ/" style="font-size:0.7em; text-indent:3em !important;">سوالهای متداول</a>
								<a href="/userManual/languagesetting" style="font-size:0.7em; text-indent:3em !important;">مشکل نمایش حروف فارسی</a>
								
								<a href="/Register/Register.asp?State=NewProfile" class="vmenu-title">ثبت نام</a>
								<a href="/Register/Register.asp?State=NewProfile" style="font-size:0.7em; text-indent:3em !important;">ثبت نام</a>
								<a href="/Register/Register.asp" style="font-size:0.7em; text-indent:3em !important;">ویرایش اطلاعات</a>
						  </li>
						</ul>
					</div>
					

				</td>
			</tr>
			<tr colspan="2" id="contentfooter" style="background:url(/Images/Content_Back---down.jpg) repeat-x bottom; height:365px;" valign="bottom" align="center">
				<td>
					<p><img src="/Images/BaharSound.png" alt="logo"/></p>
					<p>
						<a href="http://www.baharsound.com/">www.baharsound.com, </a>
						<a href="http://www.wikifeqh.ir">www.wikifeqh.ir, </a>
						<a href="http://lib.eshia.ir">lib.eshia.ir</a>
					</p>
				</td>
				<td>
				</td>
			</tr>
</table>
		<map name="Map" id="Map">
			<area shape="rect" coords="6,6,177,209" href="/" alt="logo"/>
		</map>






<!--===================================================================================================================-->
</body>
<SCRIPT ID=clientEventHandlersJS LANGUAGE=javascript>
<!--
<%if (State=="EditProfile" || State=="NewProfile") EditProfileClientFunction();
else if (State=="Exam") ExamClientFunction();%>
//-->
</SCRIPT>
</html>