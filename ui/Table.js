// JavaScript Document

function TableV1()
{
		
		
}
TableV1.prototype.bindData=function(json_arr)
{
	var tmplxx=　$("#table1_tmpl");
     tmplxx.tmpl(json_arr).appendTo('.table1');	
	// 　$("#table1_tmpl").hide();
	
}