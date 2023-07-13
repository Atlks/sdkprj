<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*"  %>
<%@page import="com.attilax.api.HandlerChain"%>
<%@page import="com.attilax.api.ApiSqlHandler"%>
<%@page import="com.attilax.hre.UrlDslParser4web"%>
<%@page import="aaaCfg.IocX4addr"%>

<%
//UrlDslParser4web c=new UrlDslParser4web();
	UrlDslParser4web  c=	IocX4addr.getBean(UrlDslParser4web.class);
 

 %>
 <%=c.exe(request)%>
 