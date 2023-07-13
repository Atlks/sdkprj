<%@page import="com.focusx.util.HbX4vod"%>
<%@page import="com.attilax.db.dbx4q"%>
 
<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*"   %>
<%  
 dbx4q.sess=HbX4vod.getSession(); %>
<%=new dbx4q().handleReq_jsFmt(request.getParameter("s"))%>
<!-- http://localhost/vod/com.attilax/util/hbx.jsp?s=select%20top%201%20*%20from%20t_mb_weixinuser -->