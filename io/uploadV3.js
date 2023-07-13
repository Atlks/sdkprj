// JavaScript Document
function AtiUploadV3(obj_selector)
{
	this.obj_selector=obj_selector;
	this.up_url;
	this.upload_finish_handler;
}
AtiUploadV3.prototype. upload=function()
{
	var self=this;
	try{
	　$("#process_div").progressBar(99);
	}catch(e){
	console.log(e);	
	}
	var fd = new FormData();
//	fd.append("upload", 1);
	fd.append("upfile", $(this.obj_selector).get(0).files[0]);
	$.ajax({
		url: this.up_url,
		type: "POST",
		processData: false,
		contentType: false,
		data: fd,
		success: function(d) {
			console.log(d);
			console.log("----fini");
		//	$("#file_val").val(d);
			// writeCookie("file_url_frmJS",$("#file_val").val(),10);
			
			 self.upload_finish_handler(d);
			 upload_finish();
		}
	});	
}

function upload_finish()
{
window.setTimeout(function()
{
	 try{
	　$("#process_div").fadeOut();
	}catch(e){
	console.log(e);	
	}	
},800);

			
}

 
// for img pre view
function getPicSrc4createObjectURL(fileControlId) {
	
file=	$("#"+fileControlId)[0].files[0];
	var url = null ; 
	if (window.createObjectURL!=undefined) { // basic
		url = window.createObjectURL(file) ;
	} else if (window.URL!=undefined) { // mozilla(firefox)
		url = window.URL.createObjectURL(file) ;
	} else if (window.webkitURL!=undefined) { // webkit or chrome
		url = window.webkitURL.createObjectURL(file) ;
	}
	return url ;
}