<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><%@ page contentType="text/html;charset=utf-8"%><%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<html >
  <head>
      <!--set ie8设定要用IE8标准模式渲染网页，而不会使用兼容的模式。-->
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style type="text/css">
  body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
  </style>
<body>
<link rel="stylesheet" type="text/css" href="bootstrap.css"/>
 <style type="text/css">
 body {
	background-color: #F5F5F5;
}
 body,td,th {
	font-size: 12px;
}
 </style>
<script src="../js/jquery-1.8.3.js" type="text/javascript"></script>
 <!--form up start-->
		<form id='fForm' class="form-actions form-horizontal" action="../spr/upload.html" 
		      encType="multipart/form-data" target="uploadf" method="post" style="margin:0px; padding:0px">
				 <div class="control-group" style="margin-bottom:3px">
					
					<table width="450" border="0" cellpadding="0" cellspacing="0">
					  <tr>
					    <td width="19" valign="top">&nbsp;</td>
					    <td width="177" valign="top"><span class="controls" style="margin:0px; padding:0px"></span>					      <input type="file"  name="file" style="width:170; font-size:12px">					    </td>
					    <td width="254" valign="top"><button type="button" id="subbut" class="btn">上传</button></td>
				      </tr>
					  <tr>
					    <td valign="top">&nbsp;</td>
					    <td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
					      <tr>
					        <td width="16%">上传进度: </td>
					        <td width="84%"><!--gressbar start-->
                              <div class="controls" style="margin-left:0px">
                                <div  class="progress progress-success progress-striped" style="width:90%; margin-bottom:0px">
                                  <div  id = 'proBar' class="bar" style="width: 0%"></div>
                                </div>
                              </div>
                            <!--gressbar--></td>
				          </tr>
				        </table></td>
				      </tr>
			       </table>
					 
		  </div>
				<!--none-->
		  <div class="control-group" style="display:none">
					<div class="controls"></div>
				</div>
		</form>
		<iframe name="uploadf"  id="uploadf" style="display:none"></iframe>
<script >
 //ext point ------- window.parent.callMeth(data.path);
 
function upfinishEvent(data)
{
	 window.parent.<%=request.getParameter("callx")%>(data.path);
	
}
$(document).ready(function(){
	$('#subbut').bind('click',
			function(){
				$('#fForm').submit();
				var eventFun = function(){
		    		$.ajax({
	    				type: 'GET',
	    				url: '../spr/process.json?'+Math.random(),
	    				data: {},
	    				dataType: 'json',
	    				success : function(data){
		    					$('#proBar').css('width',data.rate+''+'%');
			    				$('#proBar').empty();
					    		$('#proBar').append(data.show);	
					    		if(data.rate == 100){
					    			window.clearInterval(intId);
									upfinishEvent(data);
					    		}	
	    		}});};
	    		var intId = window.setInterval(eventFun,1500);
	});
});
</script>

</body></head></html>