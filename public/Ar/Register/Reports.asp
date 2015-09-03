<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Content-Language" content="fa">
<META content="IRAN; Bahar Sound; eLearning; VOIP; Q&A;" name=KEYWORDS>
<LINK href="Global\roll.css" type=text/css rel=stylesheet>
<title>Reports</title>
</head>
<%@ Language=JavaScript %>
<!--#include file="Global\Global.asp"-->
<%
	logPath = Server.MapPath("log/")+'\\'
%>	
<script LANGUAGE="jScript" RUNAT="Server">
//---------------------------------------------------------------------------------------------------------------------
function TotalReport(){
 
	OpenConnection()
	SWhere="Cast(DateIn as DateTime)+Cast(TimeIn as DateTime)>= Cast('" +
		ReadArgNotNull('FromDate','2000/01/01') + 
       "' as DateTime)+Cast('" + 
       ReadArgNotNull('FromTime','00:00:01') +"' as DateTime)"
	SWhere+=" and Cast(DateOut as DateTime)+Cast(Timeout as DateTime)<= Cast('" +
       ReadArgNotNull('ToDate','2010/01/01') + 
       "'as DateTime)+Cast('"+ 
       ReadArgNotNull('ToTime','23:59:59') +"' as DateTime)"
    Application('SWhere')=SWhere
	if(ReadArg('Group','')!='') SWhere+=" and T_CMN_Person.GroupID ="+ReadArg('Group','')

	RS=Server.CreateObject("ADODB.RecordSet");
	RS.open("Select userID,NicknamePersian ,Sum(DateDiff( s , Cast(DateIn as DateTime)+Cast(TimeIn as DateTime), Cast(DateOut as DateTime)+Cast(Timeout as DateTime))) FROM T_CMN_Person ,T_Reports_Logs Where UserID = ID and "+SWhere+" Group by userID,NicknamePersian",Conn,1,1);
	SumTimes =0
	
	Response.write('<Table border=1><BR>');
	Response.write('<TR bgcolor=#00e0ff><TD align=right>'+'مدت زمان'+'</TD><TD align=right>'+'(مدت زمان(ثانيه'+'</TD><TD align=right>'+'كد كاربري'+'</TD></TR>');		
	n=0
//	Response.write(n);
	while (!RS.Eof){
		SumTimes+=RS(2).Value;
		Response.write('<TR ><TD align=right><font color="#ffffff"><a href=Reports.asp?ID='+RS(0)+'>'+SecToHHMMSS(RS(2))+'</a></TD><TD align=right><a href=Reports.asp?ID='+RS(0)+'>'+RS(2)+'</a></TD><TD align=right><a href=Reports.asp?ID='+RS(0)+'>'+RS(1)+'</font></a></TD></TR>');		
		RS.MoveNext();
		++n;
	}	
	Response.write('<TR bgcolor=#00a0ff><TD align=right>'+SecToHHMMSS(SumTimes)+'</TD><TD align=right>'+SumTimes+'</TD><TD align=right>'+'جمع كل'+'</TD></TR>');		
	Response.write('</Table>');
	Response.write(n);
	Conn.Close();
}
//---------------------------------------------------------------------------------------------------------------------
function IndividualReport(){
 
	OpenConnection()
    SWhere = Application('SWhere')
    SWhere+=' AND UserID ='+ReadArg('Id','')
	RS=Server.CreateObject("ADODB.RecordSet");
	RS.open("Select userID,NicknamePersian,DateDiff( s , Cast(DateIn as DateTime)+Cast(TimeIn as DateTime), Cast(DateOut as Datetime)+Cast(Timeout as DateTime)),ip,datein,timein,dateout,timeout FROM T_CMN_Person ,T_Reports_Logs Where UserID = ID and "+SWhere + " Order by datein",Conn,1,1);
	SumTimes =0

	Response.write('<Table border=1><BR>');
	Response.write('<TR bgcolor=#f0f09f><TD align=Center colspan=7>'+RS(1));		
	Response.write('<TR bgcolor=#00e0ff><TD align=right >'+'مدت زمان'+'</TD><TD align=right>'+'(مدت زمان(ثانيه'+'</TD><TD align=right>'+'تا ساعت'+'</TD><TD align=right>'+'از ساعت'+'</TD><TD align=right>'+'تا تاريخ'+'</TD><TD align=right>'+'از تاريخ'+'</TD><TD align=right>'+'IP'+'</TD></TR>');		
	n=0;
	while (!RS.Eof){
		SumTimes+=RS(2).Value;
		Response.write('<TR><TD align=right>'+SecToHHMMSS(RS(2))+'</TD><TD align=right>'+RS(2)+'</TD><TD align=right>'+RS(7)+'</TD><TD align=right>'+RS(5)+'</TD><TD align=right>'+RS(6)+'</TD><TD align=right>'+RS(4)+'</TD><TD align=right>'+RS(3)+'</TD></TR>');		
		RS.MoveNext();
		++n;
	}	
	Response.write('<TR bgcolor=#00a0ff><TD align=right>'+SecToHHMMSS(SumTimes)+'</TD><TD align=right>'+SumTimes+'</TD><TD colspan=5 align=right>'+'جمع كل'+'</TD></TR>');		
	
	Response.write('</Table>');
	Response.write(n);
	Conn.Close();
}
//----------------------for showing file-----------------------------------------------------------------------------------------------
function ViewFile(FileName){
  Response.write(logPath+FileName+'<BR>');
  var fso=Server.CreateObject("Scripting.FileSystemObject")
  var fname=fso.OpenTextFile(logPath+FileName)//fs_overread
  while(!fname.AtEndOfStream)
	{
        Response.write(fname.ReadLine()+'<BR>');
	}
  fname.Close();
}
//---------------------------------------------------------------------------------------------------------------------
function ShowAllFiles(Import){

	var fso = Server.CreateObject("Scripting.FileSystemObject"); 
	var folder = fso.GetFolder(logPath); 
	var fc = new Enumerator(folder.Files); 

	OpenConnection()
	RS=Server.CreateObject("ADODB.RecordSet");
	RS.open("SELECT Max(DateIn) FROM T_Reports_Logs",Conn,1,1);

	var S = (RS(0)+"").replace("/","").replace("/","").substring(2,10)
	if (S.length<6)S='010101'
	S+='.log'
	FileFound = false
	for (; !fc.atEnd(); fc.moveNext())
		if (fc.item().name.indexOf(".log")>-1 && fc.item().name>S)
		{
			FileFound = true
			if(Import=='')  Response.write('<a href=Reports.asp?State=View&FileName='+fc.item().name+'>'+fc.item().name + "</a> -- "); 
			else {
//				S1='0'+fc.item().name
//				fso.MoveFile(logPath + fc.item().name , logPath + "Log.txt")
//				Conn.Execute ("Insert into T_Reports_Logs select * from T_Reports_InLogs where IP<>'' and UserID<>-1 and UserID<>-10"  ,'',1)
//				if (UserID!=-10)
				Conn.Execute ("BULK INSERT T_Reports_Logs FROM '"+ logPath+fc.item().name+"' WITH (FIELDTERMINATOR = ';',CHECK_CONSTRAINTS)"  ,'',1);

				Response.write(fc.item().name + " -- "); 
//				fso.MoveFile(logPath+"Log.txt",logPath+S1)				
			
			}
		}	
	RS.Close();
	
	if(Import=='') 
		if(FileFound == true) Response.write('<P align=center><form action=Reports.asp?State=Import method=post><INPUT name=bImport type="submit" value=Import></form></P>')
		else Response.write('file not found');
	else Response.write('All File Imported.')
//Response.write(fc.item().DateLastModified + "<br>"); 
//DateCreated , DateLastModified
	Conn.Close();
}
//---------------------------------------------------------------------------------------------------------------------
function Normal(){
	Response.write('<form action=Reports.asp method=post><BR>');
	Response.write('<table border="5">');
	Response.write('	<tr bgcolor=#00f0ff><td colspan=2 align = Center><a href="Reports.asp?State=Import">ورود اطلاعات</a></td><tr>');

	Response.write('	<TR><TD><INPUT maxLength=10 name=FromDate value="" size=15 dir=ltr Required=true> </TD>');
	Response.write('	<TD bgcolor=#f000ff><font color=#0000FF>:ازتاريخ</Font></TD></tr>');

	Response.write('	<TR><TD><INPUT maxLength=10 name=ToDate value=""size=15 dir=ltr Required=true> </TD>');
	Response.write('	<TD bgcolor=#f000ff><font color=#0000FF>:تا تاريخ</Font></TD></tr>');

/*	Response.write('	<TR><TD><INPUT maxLength=8 name=FromTime size=15 value=""dir=ltr Required=true> </TD>');
	Response.write('	<TD bgcolor=#f000ff><font color=#0000FF>:ازساعت</Font></TD></tr>');

	Response.write('	<TR><TD><INPUT maxLength=8 name=ToTime size=15 value="" dir=ltr Required=true> </TD>');
	Response.write('	<TD bgcolor=#f000ff><font color=#0000FF>:تا ساعت</Font></TD></tr>');
*/
	Response.write('	<TR><TD><SELECT name=Group  Required=true> ');
	Response.write('		<OPTION value="">همه');
	Response.write('		<OPTION value=100401>کاربر');
	Response.write('		<OPTION value=100402>کارمند</OPTION></SELECT></TD>');
	Response.write('	<TD bgcolor=#f000ff><font color=#0000FF>:گروه</Font></TD></TR> ');
	Response.write('	<TR bgcolor=#0000ff><TD colspan=2 align=center><INPUT name=bDoQuery type="submit" value=تائيد></TD></TR>');
	Response.write('</table>');
	Response.write('</form>');
}
//---------------------------------------------------------------------------------------------------------------------
</script>
<body  bgColor=#FFFFFF topmargin="0" leftmargin="0" >	

	<div align="center">
		<table border="0" width="800" cellspacing="0" cellpadding="0">
		  <tr>
		    <td valign="top" ><!--#include file="Header1.htm"--></td>
		    <td valign="top" align="Center">
		    <%if (ReadArg('Id','')!='')IndividualReport()
		      else if (ReadArg('bDoQuery','')!='')TotalReport()
		      else if (ReadArg('State','')=='Import')ShowAllFiles(ReadArg('bImport',''))
		      else if (ReadArg('State','')=='View')ViewFile(ReadArg('FileName',''))
		      else Normal()%>
		    </td>
		
		    <td valign="top" ><!--#include file="Header2.htm"--></td>
		
		  </tr>
		</table>
	</div>
</body>
</html>