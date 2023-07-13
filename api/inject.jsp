<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*"  %>
<%@page import="com.focusx.listener.MyListener"%>
 <%
 new MyListener().injectApiHandler_sf();
 %>
 --ok