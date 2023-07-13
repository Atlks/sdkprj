
<%@page import="com.focusx.publish.entity.GvPublish"%>
<%@page import="com.attilax.util.DateUtil"%>
<%@page import="com.attilax.collection.CollX"%>
<%@page import="java.util.HashMap"%>
 
<%@page import="com.attilax.dsm.BaseSvsO9o4Cri"%>
<%@page import="com.attilax.Stream.Mapx"%>
<%@page import="net.sf.json.JSONArray"%>
<%@page import="java.util.Map"%>
<%@page import="java.util.List"%>
<%@page import="com.attilax.io.filex"%>
<%@page import="com.attilax.System.Web.UI.WebControls.DataGridView"%>
<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*"%>
<%

//=	request.getSession().getAttribute("wait2confirmDataDetailList")
String s7="";
//DataGridView GridView1.DataSource
	String s=filex.read("c:\\dt.txt");
		JSONArray ja= net.sf.json.JSONArray.fromObject(s);
			BaseSvsO9o4Cri basesvs=new BaseSvsO9o4Cri();
			List li=	basesvs.findByPropertyss(new HashMap(), GvPublish.class);
			request.getSession().setAttribute("wait2confirmDataDetailList",li);
			response.sendRedirect("lookOverdetail.jsp");
			 
%>
 