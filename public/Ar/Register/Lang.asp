<%
          Response.write('<font face="Tahoma"  color="#374c28"><%VL_Incorret%></font>');
/////          Response.write('<font face="Tahoma"  color="#374c28">کد کاربری یا کلمه عبور درست وارد نشده است</font>');


//Login
          Response.write('<td><div align="Right"><span class="style4"><font face="Tahoma"  color="#374c28"><%VL_UserName%></font></span></div></td> ');
/////          Response.write('<td><div align="Right"><span class="style4"><font face="Tahoma"  color="#374c28">كلمه عبور</font></span></div></td> ');

          Response.write('<td align="Left"><input style=" height: 23px" type="submit" value=<%VL_Ok%> name="B1" ></td>');
/////          Response.write('<td align="Left"><input style=" height: 23px" type="submit" value=" تاييد " name="B1" ></td>');



//EditProfileClientFunction
	Response.write('{myform.'+S+'.focus(); alert(myform.'+S+'.title'+'+<%VL_Nessesery%>'+'); return false;};'+'\n'+'\n');
/////	Response.write('{myform.'+S+'.focus(); alert(myform.'+S+'.title'+'+" الزامی است "'+'); return false;};'+'\n'+'\n');

           Response.write('if(myform.eUserName.value.indexOf(" ")!=-1) '+'\n'+'{myform.eUserName.focus();alert(<%VL_NotSpace.%>);return false;};');
/////           Response.write('if(myform.eUserName.value.indexOf(" ")!=-1) '+'\n'+'{myform.eUserName.focus();alert("کد کاربری نمیتواند شامل جای خالی باشد.");return false;};');


           Response.write('if(HaveExtraChars(myform.eUserName.value)) '+'\n'+'{myform.eUserName.focus();alert(<%VL_IncoreectCharacter.%>);return false;};');
/////           Response.write('if(HaveExtraChars(myform.eUserName.value)) '+'\n'+'{myform.eUserName.focus();alert("کد کاربری نمیتواند شامل حروف غیر معتبر باشد.");return false;};');


           Response.write('if(myform.eUserName.value.length<5) '+'\n'+'{myform.eUserName.focus();alert(<%VL_AtLeast5Charcter.%>);return false;};');
/////           Response.write('if(myform.eUserName.value.length<5) '+'\n'+'{myform.eUserName.focus();alert(" کد کاربری باید حداقل 5 حرف باشد.");return false;};');


           Response.write('if(myform.epassword.value.length<4) '+'\n'+'{myform.epassword.focus();alert(<%VL_AtLeast4Character.%>);return false;};');
/////           Response.write('if(myform.epassword.value.length<4) '+'\n'+'{myform.epassword.focus();alert(" کلمه عبور باید حداقل 4 حرف باشد.");return false;};');


           Response.write('if(myform.epassword.value!=myform.Password1.value) '+'\n'+'{myform.Password1.focus();alert(<%VL_RepeatnotCorrect.%>);return false;};');
/////           Response.write('if(myform.epassword.value!=myform.Password1.value) '+'\n'+'{myform.Password1.focus();alert("تکرار کلمه عبور درست وارد نشده است.");return false;};');


           Response.write('if(NumInStr(myform.FName.value)==1) '+'\n'+'{myform.FName.focus();alert(<%VL_NotNumber.%>);return false;};');
/////           Response.write('if(NumInStr(myform.FName.value)==1) '+'\n'+'{myform.FName.focus();alert("نام نمیتواند شامل عدد باشد.");return false;};');


           Response.write('if(myform.FName.value.length<3) '+'\n'+'{myform.FName.focus();alert(<%VL_AtLeast3Character.%>);return false;};');
/////           Response.write('if(myform.FName.value.length<3) '+'\n'+'{myform.FName.focus();alert(" نام باید حداقل 3 حرف باشد.");return false;};');


           Response.write('if(NumInStr(myform.LName.value)==1) '+'\n'+'{myform.LName.focus();alert(<%VL_NotNumberFamily.%>);return false;};');
/////           Response.write('if(NumInStr(myform.LName.value)==1) '+'\n'+'{myform.LName.focus();alert("نام خانوادگی نمیتواند شامل عدد باشد.");return false;};');


           Response.write('if(myform.LName.value.length<3) '+'\n'+'{myform.LName.focus();alert(<%VL_AtLeast3CharFamily.%>);return false;};');
/////           Response.write('if(myform.LName.value.length<3) '+'\n'+'{myform.LName.focus();alert(" نام خانوادگی باید حداقل 3 حرف باشد.");return false;};');


           Response.write('if(NumInStr(myform.City.value)==1) '+'\n'+'{myform.City.focus();alert(<%VL_NotNumbCity.%>);return false;};');
/////           Response.write('if(NumInStr(myform.City.value)==1) '+'\n'+'{myform.City.focus();alert("شهر نمیتواند شامل عدد باشد.");return false;};');


           Response.write('if(myform.City.value.length<2) '+'\n'+'{myform.City.focus();alert(<%VL_AtLeast2City.%>);return false;};');
/////           Response.write('if(myform.City.value.length<2) '+'\n'+'{myform.City.focus();alert("شهر باید حداقل 2 حرف باشد.");return false;};');


         Response.write('str1= myform.EMail.value; if (str1!="" && str1.lastIndexOf("@")==-1) {myform.EMail.focus();alert(<%VL_emailNotCorrect.%>);return false;};');
/////         Response.write('str1= myform.EMail.value; if (str1!="" && str1.lastIndexOf("@")==-1) {myform.EMail.focus();alert("نشانی الکترونیکی صحیح نیست.");return false;};');


//EditProfile



var VL_Khanevadegi='نام خانوادگی';
%>