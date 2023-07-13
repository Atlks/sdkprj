/*
jeig sh xinge invoke d
*/ 

function playVideo2(url){
alert(url);
}
function playVideo(url,id){
//alert(url);
playx(url,id);
}
function playVideo3(url,id){
alert(url); 
playx(url,id);
}

/*
jeig sh jujo invoke d
*/ 
function playx(video)
{
//	alert(video);
	try{
 console.info(video);
	}catch(e){}
	try{
		
 sendNSCommand('play',video);
	}catch(e){alert(e);}
}


function playx_v2(video,id)
{
//	alert(video);
	try{
 console.info(video);
	}catch(e){}
	try{
					
		 sendNSCommand('play',video,id);
				}catch(e){alert(e);}

}
   


   function listCtrl($scope) { 

    $scope.listO7 =[ ] ; 

} 

   



//$(function() { 
//
//
//
//	loadIniData();
//	
//	dwr.engine.setAsync(false);	
//
//});



 
