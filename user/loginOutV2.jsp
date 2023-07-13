<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*"  %>
<%@ page import="com.attilax.token.TokenService"  %>
<%@ page import="com.attilax.ioc.IocUtilV2"  %>
<%


	com.attilax.token.TokenService ts=com.attilax.ioc.IocUtilV2.getBean(TokenService.class);
		ts.setModule("merMod");
		ts.clrToken(response);
		
		//mer_login.html


%>
<script>

window.location="<%=request.getParameter("url")%>";

</script>