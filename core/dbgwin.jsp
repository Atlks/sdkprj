<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*"  %>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"";
 

%>
 <link rel="stylesheet" type="text/css" href="<%=basePath%>/js/themes/default/easyui.css"/>  
    <link rel="stylesheet" type="text/css" href="<%=basePath%>/js/themes/icon.css"/>  
	    <link rel="stylesheet" type="text/css" href="<%=basePath%>/js/demo/demo.css" />


 
<script language="JavaScript" type="text/javascript" src="<%=basePath%>/js/jquery.easyui.min.js"></script>
<script language="JavaScript" type="text/javascript" src="<%=basePath%>/js/locale/easyui-lang-zh_CN.js"></script>

<!--hot key settt-->
<script type="text/javascript" src="<%=basePath%>/com.attilax/core/dbgwin.js"></script>

<!--win -->
<div id="dbgW" class="easyui-window" title="Basic dbgW Window" data-options="iconCls:'icon-save'" style="width:500px;height:200px;padding:10px;">
 <div style="margin:20px 0;">
<a href="javascript:void(0)" class="easyui-linkbutton" onclick="$('#dbgW').window('open')">Open</a>
<a href="javascript:void(0)" class="easyui-linkbutton" onclick="$('#dbgW').window('close')">Close</a>
 
</div>
<!--kstm panel-->
<jsp:include page="<%=request.getParameter(\"tmplt\")%>"  flush="true" />
<!--kstm panel ////-->

</div>  

<script >
$(function () {
$('#dbgW').window('close');
});
</script>