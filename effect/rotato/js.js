// JavaScript Document
/*  $(function () {
window.setTimeout(function()
{
	 $(".b2_cloud").removeClass("b2_cloud").addClass("b2_cloud_finish");
},500);
  });*/
 // return;
  try{
	  console.log("---start rotato effect..");
  }catch(e){}
  
 
 function paa3_redo()
 {
	 
	  try{
				  console.log("---start rotato window.setIntervalt..");
			 
			  
			  	// apply effeck
				$("#"+imgid4rotato).removeClass("rotato_ini").addClass("rotato_finish");
				 console.log("---start rotato apply effeck..");
			  //reset state
			  window.setTimeout(function()
			  {
				   $("#"+imgid4rotato).removeClass("rotato_finish").addClass("rotato_ini");
				    console.log("---reset rotato state finish .. window.setTimeout..");
				},8000);
		
			   console.log("---finish rotato window.setIntervalt..");
			   
			    }catch(e){ alert(e);}
			   
 }
 
 function  paa3()
 {
			try{
		console.log("---start rotato ini..");
		}catch(e){}
 

		try{
	//	$("#imgx").removeClass("b2_cloud").addClass("b2_cloud_finish");
		window.setInterval(function()
		{
				
			 paa3_redo();
		},9000);
		
		}catch(e){alert(e);} 
	 
 }
 
 //--------------
function rotato_start()
{
try{
	$(function(){
		//imgid="thumb
	 paa3_redo();
		 paa3();
		
	
	
	});

}catch(e)
{
	alert(e);	
}
}