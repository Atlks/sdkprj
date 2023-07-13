
 function voidx(intt)
 {
	 
 }
 
function click_effx(effectObj,callback)
{
	//alert(effectObj);
	var objP7;
	try{
	  objP7=$( "#"+effectObj );
	}catch(e)
	{
	  logx("get eff obj err,try this mode");
	  objP7=	$(  effectObj );
	}
	//alert("objhtml:"+objP7.html());
	function explodeP7()
	{
		logx("--will exploade effe");
	 // get effect type from
     var selectedEffect = "explode";
 
      // most effect types need no options passed by default
      var options = {};
      // some effects have required parameters
      if ( selectedEffect === "scale" ) {
        options = { percent: 0 };
      } else if ( selectedEffect === "transfer" ) {
        options = { to: "#to_target", className: "ui-effects-transfer" };
      } else if ( selectedEffect === "size" ) {
        options = { to: { width: 200, height: 60 } };
      }
 
      // run the effect
	  var call=callback;
	  if(callback!=null)
	     call=callback;
	  else
	     call=callbackP7;
	//	 alert(call);
	logx("---effe:"+selectedEffect);
	//alert(options);
     objP7.effect( selectedEffect, options, 500, call );	
	}
	  
	  
	  	function puff()
	{
		logx("--will puff effe");
	 // get effect type from
     var selectedEffect = "puff";
 
      // most effect types need no options passed by default
      var options = {};
       
      // run the effect
	  var call=callback;
	  if(callback!=null)
	     call=callback;
	  else
	     call=callbackP7;
	//	 alert(call);
	logx("---effe:"+selectedEffect);
 
     objP7.effect( selectedEffect, options, 500, call );	
	}
	  
	function transP7()
	{
		
	  // get effect type from
     var selectedEffect = "transfer";
 
      // most effect types need no options passed by default
      var options = {};
      // some effects have required parameters
      if ( selectedEffect === "scale" ) {
        options = { percent: 0 };
      } else if ( selectedEffect === "transfer" ) {
        options = { to: "#to_target", className: "ui-effects-transfer" };
      } else if ( selectedEffect === "size" ) {
        options = { to: { width: 200, height: 60 } };
      }
 

      // run the effect
     objP7.effect( selectedEffect, options, 500, explodeP7 ); 	
	}
	  
	   
    // callback function to bring a hidden box back
 /*   function callbackP7() {
		console.log("-----call even ");
		//return;
      setTimeout(function() {
        $( "#"+effectObj ).hide().fadeIn();
      }, 500 );
    };*/
	
	//alert(effectObj);
 	 // transP7();
  puff();
  //explodeP7();
	  
	//  ducks_and_drakes();
}

/*
//for menu show 
*/
function fadeInX(objs,i)
{
	var obj=$(objs[i]);
	if(obj)
	{
	//	alert(obj);
		console.log(obj);
	obj.fadeIn(500,function()
			{
				fadeInX(objs,i+1);	
			}
	  
	  );
	}
}
										
function fadeInBy(objs)
										{
												objs.each(function(index, element) {
													console.log(index);
													var timeoutx=1000*(index+1);
													$(element).fadeIn(timeoutx,null);
                                    
                              					  });
											
										}
										
										
										
 function  ducks_and_drakes()
  {
  var times=5;
 // var perHiReduce=0.9;
  var perFarReduce=0.85;
  var start_left=screen.width;
 // var end_left=1000;
  var start_top=300;
//  var end_top=500;
 // var cur_hi=0;
 // var cur_left=0;
  var first_step_len=500;
//  var last_stepLen=100;
 // var first_step_hi=80;
  var sec_left;
 var  sec_left_step;
  
  function fadeInX(objs,i)
{
	if(i>times)
	{
	console.log("--end");
		return;
		}
	//   last_left=cur_left;
	  sec_left_step=  first_step_len*(perFarReduce);
	   sec_left=start_left-sec_left_step;
	   console.log("---start_left"+start_left+"   sec-left:"+sec_left);
	   //'<img class="test" src="pic.jpg"></img>'
	   
	 //  static 
	//   $("#stone").css("position","static");
	   console.log( $("#stone"));
	 
     var flyobj=  $("#stone").fly({
				  start: {top: start_top, left: start_left},
				  end: {top: start_top, left: sec_left },
				   speed: 1.8,
				   autoPlay: true,  //def is true
				  //  vertex_Rtop:100, 
				  onEnd: function(){
					   // alert('End');
					   start_left=sec_left;
					   first_step_len=sec_left_step;
					   
						 console.log("---next :"+start_left+">>++"+first_step_len);
						 
						 $("#stone").data('fly',null);
						 //  setTimeout(function() {
						fadeInX(objs,i+1);	
						
					 // }, 500 );
						
					 //   this.destory();
				  }
		});  //end fly
	//	alert(obj);
	//	console.log(obj);
//	 console.log(flyobj);
 //  flyobj.play();
}
  fadeInX(null,1);
   
   
   }
								  
 