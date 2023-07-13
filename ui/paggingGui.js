 
//	var o={	pagesize:10,page:page_val,keyword:””,rows:arr};
//pagesize:10,page:1,keyword:”kwxxx”,cate_id:7

//event get_posts  list>>bind2ui
//
function listPaf2(params)
{
	var curPage= parseInt(  $("#page_ui").text(),10);
	var page_val=curPage+1;
	params.page=page_val;
     get_posts(params);
	 $("#page_ui").text(page_val);
}

function next_click()
{
	 
	//arr
	 //page from ui get
	var o={	pagesize:3,keyword:"",rows:arr,bind_handler:bindPa};
	//page gui
	 listPaf2(o);
	

}

function firstPageEvent()
{
	
}
function lastPageEvent()
{
	
}
function prePageEvent()
{
	
}
function gotoPageEvent(page)
{
	 //
	 clr_list_area();
	//arr
	 //page from ui get,
	 $("#page_ui").text(0);
	var o={	pagesize:3,keyword:"",rows:arr,bind_handler:bindPa,page:1};
	//page gui
	 listPaf2(o);
	

}

function scrollSpyEnterEvent()
{
 
    console.log('进入视口');
	$.AMUI.progress.start();
	next_click();
	window.setTimeout(function(){
		$.AMUI.progress.done();
		},2000);
	
 
}

function scrollSpyLeaveEvent()
{ console.log('离开视口');
}

function setPageSpy()
{
$(function() {
  $('#scrool_spy').on('inview.scrollspy.amui',scrollSpyEnterEvent).on('outview.scrollspy.amui',scrollSpyLeaveEvent);
  console.log("  ini ok");
  
/*$('#next_btn').scrollspy({
alert//("in view2");
//	next_click();
});*/
 
});	
	
}


