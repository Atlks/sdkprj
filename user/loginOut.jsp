<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*"  %>
<%@ page import="com.attilax.token.TokenServiceV2"  %>
<%@ page import="com.attilax.ioc.IocUtilV2"  %>
<%


	com.attilax.token.TokenServiceV2 ts=com.attilax.ioc.IocUtilV2.getBean(TokenServiceV2.class);
		ts.setUtype(request.getParameter("utype"));
		ts.clrToken(response);
		
		//mer_login.html


%>
<script>

window.location="<%=request.getParameter("url")%>";

</script>