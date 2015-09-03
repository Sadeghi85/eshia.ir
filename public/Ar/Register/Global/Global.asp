<script LANGUAGE="jScript" RUNAT="Server" >
var Conn = null

//---------------------------------------------------------------------------------------------------------------------
function OpenConnection(){
	Conn = Server.CreateObject("ADODB.Connection");
	Conn.Open("Provider=SQLOLEDB.1;Persist Security Info=True;User ID=eShia;Password=123eShia456;Initial Catalog=eShia;Data Source=(local)");
}
//---------------------------------------------------------------------------------------------------------------------
function CloseConnection(){
	Conn.Close();
	Conn=null;
}
//---------------------------------------------------------------------------------------------------------------------
function lTrim(S){
if(S==null) return S;
var I=0;
while(S.length>I && S.substr(I,1)==' ') I++;
return S.substring( I , S.length);
}
//---------------------------------------------------------------------------------------------------------------------
function rTrim(S){
if(S==null) return S;
var I=S.length-1;
while(I>0 && S.substr(I,1)==' ') I--;
return S.substring( 0 , I+1);
}
//---------------------------------------------------------------------------------------------------------------------
function Trim(S){
  return lTrim(rTrim(S));
}
//---------------------------------------------------------------------------------------------------------------------
function replaceall(S,Sub1,Sub2){
var ss = S.split(Sub1),I;
S="";
for (I=0;I<ss.length;I++)
	if (I!=	ss.length - 1)
		S +=ss[I]+Sub2;
	else S +=ss[I];
return S;
}
//---------------------------------------------------------------------------------------------------------------------
function CorrectSearchWords(SearchWords){
    var SearchWordsWhere = replaceall(SearchWords,'  ',' ');
    SearchWordsWhere = replaceall(SearchWordsWhere,' &','&');
    SearchWordsWhere = replaceall(SearchWordsWhere,'& ','&');
    SearchWordsWhere = replaceall(SearchWordsWhere,' ',' or ');
    SearchWordsWhere = replaceall(SearchWordsWhere,'&',' And ');
    return SearchWordsWhere;
}
//---------------------------------------------------------------------------------------------------------------------
function CorrectSearchWordsForSplit(SearchWords){
    var SearchWordsWhere = replaceall(SearchWords,'  ',' ');
    SearchWordsWhere = replaceall(SearchWordsWhere,' &','&');
    SearchWordsWhere = replaceall(SearchWordsWhere,'& ','&');
    SearchWordsWhere = replaceall(SearchWordsWhere,'&',' ');
    return SearchWordsWhere;
}
//---------------------------------------------------------------------------------------------------------------------
function DefDate(Dates,ix){
   
  var yy = parseInt(Dates.substr(0,2),10)
  var mm = parseInt(Dates.substr(3,2),10);
  var dd = parseInt(Dates.substr(6,2),10)+ix;

  if (dd==0)
  {    
    if(--mm==0)
    {
      yy--;
      mm=12;
    }
    if(mm<=6)dd=31
    else dd=30
  }else if (dd==32 || (dd==31 && mm>6) )
  {
    if(++mm==13)
    {
      yy++;
      mm=1;
    }
    dd=1;    
  }
  var S = yy+"/"  
  if (mm < 10) S = S + "0"  
  S = S + mm+"/"  
  if (dd < 10) S = S + "0"  
  return S + dd
 
}
//---------------------------------------------------------------------------------------------------------------------
function Hejri(Dates){//yyyy/mm/dd
  var Months=new Array(12)
  Months[0]=31;  Months[1]=28;  Months[2]=31;
  Months[3]=30;  Months[4]=31;  Months[5]=30;
  Months[6]=31;  Months[7]=31;  Months[8]=30;
  Months[9]=31;  Months[10]=30; Months[11]=31;
  var yyyy , mm , dd , hyyyy , hmm , hdd , Kabis , I , S

  yyyy = parseInt(Dates.substr(0,4),10)
  mm = parseInt(Dates.substr(5,2),10);
  dd = parseInt(Dates.substr(8,2),10);

  //if (yyyy < 97) yyyy = yyyy + 2000  else yyyy = yyyy + 1900
  

  hdd = (yyyy - 1997) * 365 + dd - 20 - (31 + 28)  

  for (I = 0 ;I<=mm - 2;I++)
    hdd += Months[I];
  
  Kabis = parseInt(parseInt(hdd / 365,10) / 4,10)  

  hyyyy = parseInt((hdd - Kabis - 1) / 365,10)
  hdd = hdd - hyyyy * 365 //- Kabis
  hyyyy = hyyyy + 1376
  if ((hyyyy - 1375) % 4 == 0) hdd = hdd + 1
  if (hdd <= 31 * 6){
    hmm = parseInt((hdd - 1) / 31,10) + 1
    hdd = hdd - (hmm - 1) * 31
  }  
  else
  {
    hmm = parseInt((hdd - 6 * 31 - 1) / 30,10) + 7
    hdd = hdd - 6 * 31 - (hmm - 7) * 30
  }
  
  S = hyyyy - 1300+"/"  
  if (hmm < 10) S = S + "0"  
  S = S + hmm+"/"  
  if (hdd < 10) S = S + "0"  
  return S + hdd
}
//---------------------------------------------------------------------------------------------------------------------
function GetCurTime()//hh:mm
{
  var d ,s
  var c = ":";

  d = new Date();
  if(d.getHours()<10) s="0"
  else s="";
  s+=d.getHours() + c

  if(d.getMinutes()<10) s+="0";
  s+=d.getMinutes()
  return  s ;  
}  
//---------------------------------------------------------------------------------------------------------------------
function GetCurDate(){//yyyy/mm/dd
    var newDateObj = new Date();
    var m , CurMDate
     
    M=newDateObj.getMonth();

    CurMDate=newDateObj.getYear()+"/";
    if (newDateObj.getMonth()<10)CurMDate+="0";
    CurMDate+=(++M)+"/";
    if (newDateObj.getDate()<10)CurMDate+="0";
    CurMDate+= newDateObj.getDate();
    return CurMDate;
}
//---------------------------------------------------------------------------------------------------------------------
function SecToHHMMSS(Sec)
{
  var SS , MM , HH
  SS = Sec % 60
  Sec -=SS
  
  if (SS<10)  SS='0'+SS
  
  MM = Sec % 3600
  Sec -=MM
  MM = MM /60
  if (MM<10)  MM='0'+MM
  
  HH =Sec / 3600
  if (HH<10)  HH='0'+HH
  return HH +':' + MM + ':' + SS
  
}
//---------------------------------------------------------------------------------------------------------------------
function ReadArg(ArgName,Def){
  if(Request.Form(ArgName).Count!=0) return Request.Form(ArgName)(1);
  else if (Request.QueryString(ArgName).Count !=0 ) return Request.QueryString(ArgName)(1);  
  else 
  {
     Result=   Session.Contents(ArgName)
     if (typeof (Result) != 'undefined' ) return Result;
/*     else 
     {
       Result=   Application.Contents(ArgName)
       if (typeof (Result) != 'undefined' ) return Result;
     }   */
  }   
  return Def ; 
}
function ReadArgNotNull(ArgName,Def){

  var S= ReadArg(ArgName,Def) ; 
  if (S=='' ) S=Def;
  return S
}
//---------------------------------------------------------------------------------------------------------------------
function GetSubStr(SubS,S,color1,color2){
  if (SubS=="") {
    Response.Write("<FONT face=nazanin color="+color1+" size=4>");
    Response.Write(S);
    Response.Write("</FONT>");
    Response.Write("<br>");    
    return;
    }
  
  var s= ""+S , ss , J;  
  ss = s.split(SubS);
  J=0;
  while (J<ss.length) {
    Response.Write("<FONT face=nazanin color="+color1+" size=4>");
    Response.Write(ss[J]); 
    Response.Write("</FONT>");
    if(J<ss.length-1){
    Response.Write("<FONT face=nazanin color="+color2+" size=4>");
      Response.Write(SubS); 
      Response.Write("</FONT>");
    }
    J++;
   }
  Response.Write("<br>");    
}
//---------------------------------------------------------------------------------------------------------------------
function IsNull(Vlu){
  if (Vlu=="" || Vlu==null) return true
  else return false ; 
}
function IsNullThenDef(Vlu,Def){
  if (Vlu==null) return Def
  else return Vlu ; 
}
//---------------------------------------------------------------------------------------------------------------------
function CreateDBCompoBox(Name,Required,disabled,Sql,SelectedItem,Width,FirstNull,Title){//Fields = {ID, Vlu }
		  var ConnFlag;
		  if (Conn==null){ ConnFlag=0; OpenConnection();};
		  else ConnFlag=1;

          Response.write('<SELECT name='+Name+' Required='+Required+' '+disabled+' title="'+Title+'"');
          if (!IsNull(Width)) Response.write(' style="WIDTH:'+Width+'"')
          Response.write(' >');
		  var RS=Server.CreateObject("ADODB.RecordSet")
          RS.open(Sql  ,Conn,1,1);
	  if(FirstNull==1)
                 Response.write('<OPTION value=>');
          while(!RS.EOF){
				Response.write('<OPTION value='+RS("ID"));
				if (RS("ID").Value == SelectedItem) Response.write(' Selected ');
				Response.write('>'+RS("Vlu"));
				RS.MoveNext();
          }
          RS.Close();          
          Response.write('		</OPTION></SELECT>');

          if (ConnFlag==0)CloseConnection();
}
//---------------------------------------------------------------------------------------------------------------------
function CreateRadioGroup(Name,Required,disabled,Sql,SelectedItem,Width){//Fields = {ID, Vlu }
		  var ConnFlag;
		  if (Conn==null){ ConnFlag=0; OpenConnection();};
		  else ConnFlag=1;

		  var RS=Server.CreateObject("ADODB.RecordSet")
          RS.open(Sql  ,Conn,1,1);

          while(!RS.EOF){
		      Response.write('<input type="radio" name='+Name+' Required='+Required+' '+disabled+' value='+RS("ID"));
			  if (!IsNull(Width)) Response.write(' style="WIDTH:'+Width+'"');
			  if (RS("ID").Value == SelectedItem) Response.write(' checked ');
          
			  Response.write(' >');
			  Response.write(RS("Vlu")+'<BR>');
			  RS.MoveNext();
          }
          RS.Close();          

          if (ConnFlag==0)CloseConnection();
}
//---------------------------------------------------------------------------------------------------------------------
function CreateDBGrid(Title,Sql,Lables,TitleColor,TitleHight,TableColor,TableWidth,RowHeight,Row){//Fields = {,}
		  var ConnFlag , I,RowNo;
		  if (Conn==null){ ConnFlag=0; OpenConnection();};
		  else ConnFlag=1;
		  
		var RS=Server.CreateObject("ADODB.RecordSet")
		RS.open(Title  ,Conn,1,1);
		Title = RS(0).value;
		RS.Close();
          Response.write('<p align=center dir=rtl>'+Title+'</p>');
		  	
          RS.open(Sql  ,Conn,1,1);
          if(RS.EOF )
          {
			Response.write('<p style="color=#FF0000" align=center>ركوردي وجود ندارد</p>');
			RS.Close();
			return
          }  
          Response.write('<table border="0" cellspacing="0" cellpadding="0" align="Center" dir=rtl width='+TableWidth+' bgColor='+TableColor+'>');
          Response.write('<TR bgColor='+TitleColor+' height='+TitleHight+'>');
		  for (I=0; I<Lables.length;I++)
               Response.write('<TD >'+Lables[I]+'</TD>');
          Response.write('<\TR>');
	if(Row==1)RowNo=0;
          while(!RS.EOF ){
              Response.write('<tr height='+RowHeight+'>');
	if(Row==1){RowNo++;Response.write('<TD >'+RowNo+'</TD>');}

			  for (I=0; I<RS.fields.Count;I++)
			  {
				Response.write('<td >');
				Response.write(RS.fields(I));
                Response.write('</td>');
              }  
              Response.write('</tr>');
              RS.MoveNext();
          }

          Response.write('</table>');
          RS.Close();          
          if (ConnFlag==0)CloseConnection();
}
//---------------------------------------------------------------------------------------------------------------------
function CreateDBTreex(RS){//Fields = {ID, PID , Title}
	var ID 
	
	if(RS("Title").value.indexOf("Href")!=-1)	S='<img src="/Images/folderopen.gif">'+RS("Title");
	else	S='<img src="/Images/Plus.gif" class = image name=imgSj'+RS('ID')+' id=Sj'+RS('ID')+'>'+RS("Title");
   	
   	Response.write('<ul class=Outline id=Sj'+RS('ID')+'>'+S);

   	ID = RS('ID').value	   	
	RS.MoveNext();	
	

	if (!RS.Eof && ID == RS('PID').value) 
	{
		if(RS("PID").value==null) Display=""
		else	Display="none"
		Response.write('<DIV style="Display='+Display+'" id=Sj'+ID+'Details>')	
		while (!RS.Eof && ID == RS('PID').value)
			CreateDBTreex(RS);   				
		Response.write('</DIV>')
	}
	Response.write('</ul>')	
}
//---------------------------------------------------------------------------------------------------------------------
function CreateDBTree(Sql){//Fields = {ID, PID  , Title}
    var ConnFlag , I;
    if (Conn==null){ ConnFlag=0; OpenConnection();};
    else ConnFlag=1;

    var RS=Server.CreateObject("ADODB.RecordSet");
    RS.open( Sql , Conn, 1, 1);
		while (!RS.Eof )			CreateDBTreex(RS);   				
    RS.Close();
    if (ConnFlag==0)CloseConnection();
}
//---------------------------------------------------------------------------------------------------------------------
function OpenSql(Sql){
    var ConnFlag , I,Result;
    if (Conn==null){ ConnFlag=0; OpenConnection();};
    else ConnFlag=1;

    var RS=Server.CreateObject("ADODB.RecordSet");
    RS.open( Sql , Conn, 1, 1);
	Result=RS(0).value;
    RS.Close();
    if (ConnFlag==0)CloseConnection();
    return Result;
}
//---------------------------------------------------------------------------------------------------------------------
</script>
