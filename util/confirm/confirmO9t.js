// JavaScript Document

	function logx(msg) {
  try {
	   console.info("----------from  logx");
    console.info("--"+msg);
  } catch (e) {
    // not support console method (ex: IE)
  }
}
function confirmO9t()
{
	this.tmplt;
	this.tmplt1;
	this.startTime;
	this.endTime;
	this.ConfmBackEvt;
	this.backHandle;
	confirmO9t.prototype.show2=function(){};
	
	
}

confirmO9t.prototype.show = function(){  
//if(approot=="/")
//var approot2="";
var url=approot+'com.attilax/util/confirm/confirmBox.jsp?confmEveHandle='+this.backHandle+'&tmplt='+this.tmplt+'&tmplt1='+this.tmplt1+'&startTime='+this.startTime+'&endTime='+this.endTime;

logx(url);
//alert(url);
// window.open(theURL,winName,features);
     	window.open(url,null,'status=yes,scrollbars=yes,resizable=yes,width=500,height=300,toolbar=yes,location=yes,status=yes,menubar=yes');
//alert("aft open");
}
confirmO9t.prototype.setConfmBackEvt = function(e){  
     //	e();
ConfmBackEvt=e;
}
