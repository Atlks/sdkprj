 //---------impt cms_api.js
 /*
   get_posts(params);
   
   imp evetn   iniUi  and newpageevent 
 */
 
 
//	var o={	pagesize:10,page:page_val,keyword:””,rows:arr};
//pagesize:10,page:1,keyword:”kwxxx”,cate_id:7

//event get_posts  list>>bind2ui
//
//  function onSelectPage (new_pageNumber, pageSize)
var obj1=function(){
	
	this.p1;
}
obj1.prototype.m1=function(){}
function paggingGui()
{
	
	//next_click_evt
	this.onSelectPage=null;
	this.m1;
	this.list=[];
	this.total=0;
	this.pageSize=10;
}


paggingGui.prototype.iniUi=function(info)
{
//{pageSize
//    total:2000,
//   
//    }	
if(!info)
{
	info={};
	info.data={};
}
var total=info.total;
if(!info.total)
	total=this.total;
 var pageSize=info.pagesize;
 //$("#"+pageSizeCtrl).val();
 $("#page_ui").html(info.page);
 
 if(!info.data.length)
	 datalen=this.list.length;
 else
	 datalen=info.data.length;
 var totalpage=getTotalpage(datalen,info.pagesize);
$("#totalPages").html(totalpage);
 $("#pages_ui").html(totalpage);
//fix page err
//try{
//var curPage= parseInt(  $("#"+pageCtrlId).val(),10);
var curPage=info.page;
var  totalPageShow= parseInt($("#totalPages").text(),10);
/**
if(curPage>totalPageShow)
{
	//setNextPageInfoNPaging(1);
}
}catch(e){}
*/


$("#totalRows").html(total);
$("#row_ui").html(total);
//$("#page1").val(info.page);
$("#pagesize1").val(this.pageSize);
//if(info.pageNumber==null)
 //setBtnDisabled()
$(".nextbtn").on('click',this.next_click.bind(this));
$(".prebtn").on('click',this.prePageEvent.bind(this));

}

paggingGui.prototype.next_click=function ()
{
	 
	//arr
	 //page from ui get
	var params={	pagesize:1,keyword:"",rows:this.list,bind_handler:null,data: this.list};
	//page gui
	// listPaf2(o);
	var curPage= parseInt(  $("#page1").val(),10);
	var page_val=curPage+1;
	$("#page1").val(page_val);
	
	params.page=page_val;
	params.pagesize= parseInt($("#pagesize1").val(),10);
	 $("#page_ui").text(page_val);
    this.onSelectPage(params );
	
	

}
paggingGui.prototype.m1=function(){}

 


function firstPageEvent()
{
	
}
function lastPageEvent()
{
	
}
paggingGui.prototype.prePageEvent=function()
{
	//arr
	 //page from ui get
	var params={	pagesize:3,keyword:"",rows:arr,bind_handler:null,data: this.list};
	//page gui
	// listPaf2(o);
	var curPage= parseInt(  $("#page1").val(),10);
	var page_val=curPage-1;
	$("#page1").val(page_val);
	params.page=page_val;
	params.pagesize= parseInt($("#pagesize1").val(),10);
	 $("#page_ui").text(page_val);
    this.onSelectPage(params );
}

/**
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
*/

function scrollSpyEnterEvent()
{
 
    console.log('进入视口');
	$.AMUI.progress.start();
//	next_click();  /tmp qbf
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


