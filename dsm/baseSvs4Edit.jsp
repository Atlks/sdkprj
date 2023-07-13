<%@page import="com.attilax.ioc.IocX"%>
<%@page import="com.attilax.dsm.baseSvs4editBean"%>
<%@ page language="java" import="java.util.*" pageEncoding="UTF-8"%><%
 //?cls=com.attilax.biz.Timerang.TimeRangRec
String cls=request.getParameter("cls");
String  tit="tt";
baseSvs4editBean c= IocX.getBean(baseSvs4editBean.class);
c.exec(request,response);
 
%>
 
