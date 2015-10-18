
﻿
window.isIOS=/Mac OS/i.test(navigator.userAgent);
function hideUrlBar(){var container=document.getElementById("container"),h=window.isIOS?44:0;if(container){var cheight;switch(window.innerHeight){case 208:cheight=268;break;case 260:cheight=320;break;case 336:cheight=396;break;case 356:cheight=416;break;case 424:cheight=484;break;case 444:cheight=504;break;default:cheight=window.innerHeight;}
if(window.isIOS){cheight-=44;}
if((cheight)&&((container.offsetHeight!=cheight)||(window.innerHeight!=cheight))){container.style.height=cheight+"px";setTimeout(function(){hideUrlBar();},1000);}}
try{document.getElementsByTagName("body")[0].style.marginTop="0px";}catch(e){}
window.scrollTo(0,0);if(window.isIOS){try{container.style.height=document.documentElement.clientHeight-44+"px";}catch(e){}}
pano=pano||document.getElementById('pano');if(pano&&pano.tagName&&pano.tagName=='OBJECT'){pano.width=document.documentElement.clientWidth;pano.height=document.documentElement.clientHeight-h;}}
function goBack(){if(!goBack.count){goBack.count=1;}
var houseid=gQuery.houseid;if(window.isIOS){if(history.length>1){history.back();}else
{
	//location.href='http://trade.qq.com/fangchan/3dfull.html?houseid='+houseid;
	}
return;}
try{WeixinJSBridge.invoke('closeWindow');goBack.count+=1;}catch(e){if(gBack.count<=10&&/MicroMessenger/i.test(navigator.userAgent)){setTimeout(goBack,500);}else if(document.referrer){location.href=document.referrer;}else{location.href='http://trade.qq.com/fangchan/3dfull.html?houseid='+houseid;}}}
function split(str){var arr=str.split("&"),obj={};for(var i=0,il=arr.length;i<il;i++){var tmp=arr[i].split("=");if(tmp.length==2){tmp[0]=tmp[0].replace(/[^\w\d]+/gi,'');tmp[1]=tmp[1].replace(/[\"\'<>]+/gi,'');obj[tmp[0]]=tmp[1];}}
return obj;}
function initGQuery(){var s=location.search.substr(1),h=location.hash.substr(1);window.gQuery=split(s);window.gHash=split(h);if(!window.isIOS){hideDiv();return;}
hideToolbar();}
function hideDiv(){var divs=document.getElementsByTagName('div');for(var i=0,il=divs.length;i<il;i++){if(divs[i].className=='view_change'){divs[i].style.display="none";return;}}
setTimeout(hideDiv,35);}
function hideToolbar(){try{WeixinJSBridge.invoke('hideToolbar');}catch(e){setTimeout(hideToolbar,30);}}
function showToolbar(){try{WeixinJSBridge.invoke('showToolbar');}catch(e){setTimeout(showToolbar,30);}}
function updateShareData(data){window.shareData=window.shareData||{};for(var i in data){if(typeof(data[i])=='object'){continue;}
shareData[i]=data[i];}
if(data.full3d){if(data.full3d.desc){shareData.desc=data.full3d.desc;}
if(data.full3d.link){shareData.link=data.full3d.link;}}
if(window.gQuery&&gQuery.desc){shareData.desc=decodeURIComponent(decodeURIComponent(gQuery.desc));}
if(window.gQuery&&gQuery.qrcode&&/^\w\d+$/i.test(gQuery.qrcode)){shareData.qrcode=gQuery.qrcode;}}
initGQuery();
try 
{
window.addEventListener("load",hideUrlBar);window.addEventListener("resize",hideUrlBar);window.addEventListener("orientationchange",hideUrlBar);
}
catch(e)
{
}