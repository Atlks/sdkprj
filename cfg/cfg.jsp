<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" %>
 
<%
String path = request.getContextPath();
String subprj=com.attilax.cfg.JvmCfg.getProperty("subprj");
try
{
%>
$app_path="<%=path%>";   
app_path="<%=path%>";
$approot="<%=path%>";  
  approot="<%=path%>";  
$envi="java";
 
$iocx_iner="nonex";
$iocx="nonex";
hre_web_url="/wrmiServlet";
subprj="<%=subprj%>";  
    
 <%
}catch(Exception e)
{
	e.printStackTrace();
}
	
	%>