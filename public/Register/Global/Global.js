<!--
//Programer:Seyyed Mahdi Hassani
//---------------------------------------------------------------------------------------------------------------------
function Img_Effect(img1,Dancite) {
img1.filters.alpha.opacity=Dancite;
}
//---------------------------------------------------------------------------------------------------------------------
var mode=1;
function FARKeyDown(){
  if (window.event.shiftKey && window.event.altKey) {
    if (mode==0) {
      mode=1;
        window.defaultStatus="Farsi Mode - ";
      }else{
         mode=0;
        window.defaultStatus="English Mode - ";
      }
      window.event.returnValue=false
      return
    }
  window.event.returnValue=true
}
function FARKeyPress(){
  var key;  
  key=window.event.keyCode;
  window.event.altKey
  
  if (key>127) return;    

  if (mode==1){  
    switch (String.fromCharCode(key)){    
        case "H":window.event.keyCode=1570;break;
        case "h":window.event.keyCode=1575;break;

        case "F":
        case "f":window.event.keyCode=1576;break;

        case "`":window.event.keyCode=1662;break;
        case "j":
        case "J":window.event.keyCode=1578;break;
        case "e":
        case "E":window.event.keyCode=1579;break;
        case "[":window.event.keyCode=1580;break;
        case "]":window.event.keyCode=1670;break;
        case "p":
        case "P":window.event.keyCode=1581;break;
        case "o":
        case "O":window.event.keyCode=1582;break;
        case "n":
        case "N":window.event.keyCode=1583;break;
        case "b":
        case "B":window.event.keyCode=1584;break;
        case "v":
        case "V":window.event.keyCode=1585;break;
        case "c":
        case "C":window.event.keyCode=1586;break;
        case "\\":window.event.keyCode=1688;break;
        case "s":
        case "S":window.event.keyCode=1587;break;
        case "a":
        case "A":window.event.keyCode=1588;break;
        case "w":
        case "W":window.event.keyCode=1589;break;
        case "q":
        case "Q":window.event.keyCode=1590;break;
        case "x":
        case "X":window.event.keyCode=1591;break;
        case "z":
        case "Z":window.event.keyCode=1592;break;
        case "u":
        case "U":window.event.keyCode=1593;break;
        case "y":
        case "Y":window.event.keyCode=1594;break;
        case "t":
        case "T":window.event.keyCode=1601;break;
        case "r":
        case "R":window.event.keyCode=1602;break;
        case ";":window.event.keyCode=1603;break;
        case "'":window.event.keyCode=1711;break;
        case "g":
        case "G":window.event.keyCode=1604;break;
        case "l":
        case "L":window.event.keyCode=1605;break;
        case "k":
        case "K":window.event.keyCode=1606;break;
        case ",":window.event.keyCode=1608;break;
        case "i":
        case "I":window.event.keyCode=1607;break;
        case "d":window.event.keyCode=1610;break;
        case "D":window.event.keyCode=1609;break;
        case "m":
        case "M":window.event.keyCode=1574;break;
      }
    }
    window.event.returnValue=true;
}
function Sec2Str(i){
	h=Math.floor(i/3600)+':';
	if (h.length<3)h='0'+h
	
	i=i-Math.floor(i/3600)*3600
	m=Math.floor(i/60)+':';
	if (m.length<3)m='0'+m;
		
	i=i-Math.floor(i/60)*60
	if (i<10)h=h+m+'0'+i;
	else h=h+m+i;
	return h;
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

//-->