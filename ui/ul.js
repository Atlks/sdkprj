// JavaScript Document
var tmp_Ulist;
function Ulist(controlId)
{
		this.ctrlId=controlId;
		this.up2end;

		
}



Ulist.prototype.setFocus2nowSelectedItem= function()
{
	var now=this.getNowSelectedControl();
	setFocusNSelect(now);
	
}

Ulist.prototype.scrollTop= function(heightx)
{
	$(".listBlock_main").scrollTop(0);
	//setFocusNSelect(now);
	
}

Ulist.prototype.set_first_selected= function()
{
	 
	var li=$("#table1 li");
	var it=li[0];
	/*
	$(it).addClass("selected");	
	$(it).focus();
	$(it).attr("tabindex","-1");
	*/
	setFocusNSelect($(it));
	
}

	$(".listBlock_main").scrollTop

Ulist.prototype.getNowSelectedControl= function()
{
	
		var now=$(".listBlock_main .sltOnly").get(0);
	    if(!now)
	    {
	    	now=getDatablockFirstShowItem();
	    	//$(".listBlock_main li").get(0);
	    }
		return now;
}

Ulist.prototype.getNowSelectedControl_only= function()
{
	
		var now=$(".listBlock_main .sltOnly").get(0);
	   
		return now;
}

Ulist.prototype.cancelFocus=function()
{
	var arr=$("#table1 li");
	arr.each(function(index, element) {
		cancelFocus($(element));
	}
	);
}


//for data item down evt
function key_press_hadler(obj)
{
   //  alert(obj);
	
	 var next=$(obj).next();
	 if(next.length==0){return;};
	 
	// window.setTimeout(function(){set_page_info(next)},10);
	set_page_info(next);
	//  ;

  //q44  position().top 是相对父元素的 for parent element ,, offset().top  base on win
	  var top=$(next).position().top;
	  var curBaseTop=  $(".listBlock_main").scrollTop()+240;
	  if(top>curBaseTop)   //in hide 
	  {

	  		$(".listBlock_main").scrollTop(curBaseTop);
	  }
	 
	 
	
	 setFocusNSelect(next);//  next
	 cancelFocusNSelect(obj);//	   $(obj).removeClass("selected");
	
}

function key_press_hadler4up(obj)
{
   //  alert(obj);
	
	 var next=$(obj).prev();
	  if(next.length==0){

	  	//
	  //	var li=new Ulist("table1");
//	    cancelFocusNSelect(obj);
	  	tmp_Ulist.up2end();
	  	return;
	  };

	set_page_info(next);
	   //q44  position().top 是相对父元素的 for parent element ,, offset().top  base on win
	  var top=$(next).position().top;
	  var curBaseTop=  $(".listBlock_main").scrollTop();
	  if(top<curBaseTop)   //in hide 
	  {

	  		$(".listBlock_main").scrollTop(curBaseTop-240);
	  }
	 
	 
	//  $(obj).removeClass("selected");
	// next.addClass("selected");	
	 setFocusNSelect(next);//  next
	 cancelFocusNSelect(obj);//	 


	 
	//  window.setTimeout(function(){set_page_info(next)},10);
}
//for data block
function set_first_selected()
{
	 
	var li=$("#table1 li");
	var it=li[0];
	/*
	$(it).addClass("selected");	
	$(it).focus();
	$(it).attr("tabindex","-1");
	*/
	setFocusNSelect($(it));
	
}


function getDatablockFirstShowItem()
{
	 var curBaseTop=  $(".listBlock_main").scrollTop();
	 var now;
	 $("#table1 li" ).each(function(index, el) {
	 	   
	 	     var top=$(el).position().top;
	 	     if( top >curBaseTop )
	 	   		return false //break;

	 });
	 return now;
}


function getNowSelectedControl_from_datablock()
{
	
		var now=$(".listBlock_main .sltOnly").get(0);
	    if(!now)
	    {
	    	now=getDatablockFirstShowItem();
	    	//$(".listBlock_main li").get(0);
	    }
		return now;
}



function bindEvent_4_dataBlock_bak()
{
var arr=$("#table1 li");
arr.each(function(index, element) {
   // $(element).keypress(function(){
     // 			  alert('keypress');
    //       });
		   var id="data_aid_"+index;
	 $(element).attr("id","data_aid_"+index);
	objEvtMap[ id ]=function(evt,element)
	{
		if(evt=="down")
			key_press_hadler($(element));
		if(evt=="up")
			key_press_hadler4up($(element));
		 	if(evt=="left")
 			{};
		if(evt=="rit")
			{}
		
		
	};

	objEvtMap[ id+"--enter" ]=function(element)
	{
		 	var now=	getNowSelectedControl_from_datablock();
		var url=$(now).attr("url");		
		browExt.play(url);
	};
	objEvtMap[ id+"--left" ]=function(element)
	{
		   cancelFocus(element);
			setFocus($(".title_playIcon"));
	};
	objEvtMap[ id+"--rit" ]=function(element)
	{
		   var now=getNowFocusControl();
		   cancelFocus(now);
			setFocus($(".title_playIcon"));
	};
	
	
	});	//end foreach


	
	
}