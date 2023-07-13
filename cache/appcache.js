// JavaScript Document

 function upEvt()
 {
	 console.log("---upevt：page is cache updated .will be reload..页面缓存有所更新");
	 alert("up..");
	window.location.reload(); 
 }
    var cache=window.applicationCache;
	cache.addEventListener("updateready",upEvt,false);