// JavaScript Document
/*  $(function () {
window.setTimeout(function()
{
	 $(".b2_cloud").removeClass("b2_cloud").addClass("b2_cloud_finish");
},500);
  });*/
  
  function logQ3(msg)
  {
	    try{
	 console.log(msg); 
	   }catch(e){}
  }
  
 
  logQ3("---start cloud..");
 
  
  function takeEffectQ4()
  {
	    $("#cloud_img").show();
	  $("#cloud_img").removeClass("b2_cloud").addClass("b2_cloud_finish"); //limiditely start 
	  
  }
  
  
  var main_q412= function(){
		 
		logQ3("---start cloud ini.."); 

	 
		 
		 var  main_taskQ3=function()
		{
				 
				  logQ3("---start effe cloud float..");
			 
			  
			  //reset state
			  window.setTimeout(function()
			  {
				   $("#cloud_img").removeClass("b2_cloud_finish").addClass("b2_cloud");
				},10000);
			 takeEffectQ4();
			 
			 
		};
		 takeEffectQ4();
		window.setInterval(main_taskQ3,12000);
		
	 
 
 

 };   //main_q412
  
  function cloud_start()
  {
	//  Zepto
	 try{
		$(main_q412);
	   
	}catch(e)
	{
		logQ3(e);
	}
  }