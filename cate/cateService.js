// JavaScript Document
 function cateService()
 {
	this.ctrlId=""; 
	 
 }
 cateService.prototype.bind=function(controlId)
 {
	// alert($("#aaaa"));
	//todox q3 if ctro is not exist 
	// if 
	 var p={"tb":"wxb_good_type","v":"type_id","txt":"type_name"};
	  var bdbr=new SelectDataBinder();
	 bdbr.bind(controlId,p);
	 
 }
 
// var sdb=new SelectDataBinder("cate_id");

	
	var aa={};