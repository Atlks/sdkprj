// JavaScript Document

// JavaScript Document
//----------------not with ui ..should overrid yha ..
//------------js function overrid by  js file order ..
// JavaScript Document
//todox  ini pageInfoStyle pagesize and bind SelectPageevent===query..


//=========================================
  
//function pageIni(info)
//{
////{
////    total:2000,
////    pageSize:10
////    }	
//var total=info.total;
//var pageSize=info.pageSize;
//$("#totalPages").html(total/pageSize);
//$("#totalRows").html(total);
////if(info.pageNumber==null)
////if($("#page").val()=="")
////	$("#page").val(1);
//}
// setPageInfo({"total":data.total,"pageSize":7});

var pageCtrlId="pagex";
var pageSizeCtrl="pagesizex";
function setPageInfo(info)
{
//{pageSize
//    total:2000,
//   
//    }	
var total=info.total;
 var pageSize=$("#"+pageSizeCtrl).val();
$("#totalPages").html(Math.ceil(total/pageSize));

//fix page err
try{
var curPage= parseInt(  $("#"+pageCtrlId).val(),10);
var  totalPageShow= parseInt($("#totalPages").text(),10);
if(curPage>totalPageShow)
{
	//setNextPageInfoNPaging(1);
}
}catch(e){}


$("#totalRows").html(total);
//if(info.pageNumber==null)
 setBtnDisabled()
}

function resetPageTo1()
{
	 $("#"+pageCtrlId).val(1);
	 	$("#page_page_lab").html(1);
}
/**
with ui  logix yda l ..
*/
   function setBtnDisabled()
   {
	var curPage= parseInt(  $("#"+pageCtrlId).val(),10);
	$("#nextLastPageBtnArea").show();
		$("#firstPrePageBtnArea").show();
	if(curPage==1)
	{
		$("#firstPageBtn").attr("disabled",true);
		 $("#prePageBtn").attr("disabled",true);
		 	$("#firstPageBtn,#prePageBtn").addClass('disable');
			$("#firstPrePageBtnArea").hide();
	}   
	if(curPage==$("#totalPages").text())
	{
		$("#nextLastPageBtnArea").hide();
	//	$("#firstPrePageBtnArea").hide();
	}
   }

function nextPage()
{
	if(!$("#"+pageCtrlId))
		logx("cant find patge ctrol ");
	logx( " patge ctrol "+$("#"+pageCtrlId).val());
	var curPage= parseInt(  $("#"+pageCtrlId).val(),10);
	var nextPage=curPage+1;
		
		$("#"+pageCtrlId).val(nextPage);
	//	$("#page_page_lab").html(nextPage);
	var pagesize=$("#"+pageSizeCtrl).val();
	onSelectPage(nextPage,pagesize);
	//set btn state disable/enable	
	setBtnDisabled()
}
function firstPage()
{
	var curPage= parseInt(  $("#"+pageCtrlId).val(),10);
	var nextPage=1;
		setNextPageInfoNPaging(nextPage);
		setBtnDisabled()
	
}
function lastPage()
{
	var curPage= parseInt(  $("#"+pageCtrlId).val(),10);
	var nextPage=$("#totalPages").text();
//	setNextPageInfoNPaging(nextPage);

	$("#"+pageCtrlId).val(nextPage);
	//	$("#page_page_lab").html(nextPage);
	var pagesize=$("#pagesize").val();
	onSelectPage(nextPage,pagesize);
	
	
	setBtnDisabled()
	
}

function prePage()
{
	var curPage= parseInt(  $("#"+pageCtrlId).val(),10);
	var nextPage=curPage-1;
	
//	setBtnDisabled()
//setNextPageInfoNPaging(nextPage);
	$("#"+pageCtrlId).val(nextPage);
	//	$("#page_page_lab").html(nextPage);
	var pagesize=$("#"+pageSizeCtrl).val();
	onSelectPage(nextPage,pagesize);
	 
	
}



function 	setNextPageInfoNPaging(nextPage)
{
		$("#"+pageCtrlId).val(nextPage);
	//	$("#page_page_lab").html(nextPage);
	var pagesize=$("#pagesize").val();
	onSelectPage(nextPage,pagesize);
}
function page_go()
{
var goPage;
try{
goPage= parseInt(  	$("#pageItem").val(),10);
}catch(e)
{alert(e);return;
}
//var curPage= parseInt(  $("#"+pageCtrlId).val(),10);
if(goPage=="")
{alert("页码不能为空");return;
}
if(goPage<=0)
{
	alert("页码不能小于0");return;
}
var  total= parseInt($("#totalPages").text(),10);
if(goPage>total)
{alert("跳转页数不能大于总页数，请重新输入");return;}
setNextPageInfoNPaging(goPage);
	setBtnDisabled();

}