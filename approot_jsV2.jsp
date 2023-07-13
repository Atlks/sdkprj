<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" %>
 
<%
String path = request.getContextPath();
try
{
%>
$app_path="<%=path%>";   
app_path="<%=path%>";
$approot="<%=path%>";   
$envi="java";
apiurl="<%=com.attilax.uti.global.GlobalService.getCfgVal("hre_web_url")%>";
$iocx_iner="nonex";
$iocx="nonex";
/*
    /wxb
    
    */
    
 <%
}catch(Exception e)
{
	e.printStackTrace();
}
	
	%>