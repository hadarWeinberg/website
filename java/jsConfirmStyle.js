ocument.getElementById('jsconfirm').style.top=-1000;
document.location.href=leftJsConfirmUri;
}
function rightJsConfirm() {
document.getElementById('jsconfirm').style.top=-1000;
document.location.href=rightJsConfirmUri;
}
function confirmAlternative() {
if(confirm("Scipt requieres a better browser!"))       document.location.href="http://www.mozilla.org";
 }

leftJsConfirmUri = '';
rightJsConfirmUri = '';

/**
 * Show the message/confirm box
*/
function showConfirm(confirmtitle,confirmcontent,confirmlefttext,confirmlefturi,confirmrighttext,confirmrighturi)  {
document.getElementById("jsconfirmtitle").innerHTML=confirmtitle;
document.getElementById("jsconfirmcontent").innerHTML=confirmcontent;
document.getElementById("jsconfirmleft").value=confirmlefttext;
document.getElementById("jsconfirmright").value=confirmrighttext;
leftJsConfirmUri=confirmlefturi;
rightJsConfirmUri=confirmrighturi;
xConfirm=xConfirmStart, yConfirm=yConfirmStart;
if(ie5) {
    document.getElementById("jsconfirm").style.left='25%';
    document.getElementById("jsconfirm").style.top='35%';
}
else if(nn6) {
    document.getElementById("jsconfirm").style.top='25%';
    document.getElementById("jsconfirm").style.left='35%';
}
else confirmAlternative();
}