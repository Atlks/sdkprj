<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*"  %>
<%@ page import="com.attilax.token.TokenServiceV2"  %>
<%@ page import="com.attilax.ioc.IocUtilV2"  %>
<%

     com.attilax.lang.Global.req.set(request);
    	com.attilax.lang.Global.resp.set(response);
	com.attilax.token.TokenServiceV2 ts=com.attilax.ioc.IocUtilV2.getBean(TokenServiceV2.class);
		ts.setUtype("admMod");
	String urole=ts.getUrole();
	String uid_cur=ts.getuid();
	String uname_cur=ts.getuid();	
		//mer_login.html


%>
 

var urole="<%=urole%>";
var uid_cur="<%=uid_cur%>";

 