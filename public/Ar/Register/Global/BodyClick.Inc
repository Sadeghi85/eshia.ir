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