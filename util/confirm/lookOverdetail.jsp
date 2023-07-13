<%@page import="com.attilax.util.DateUtil"%><%@page import="com.attilax.collection.CollX"%><%@page import="java.util.HashMap"%><%@page import="com.attilax.dsm.BaseSvsO9o4Cri"%><%@page import="com.attilax.Stream.Mapx"%><%@page import="net.sf.json.JSONArray"%><%@page import="java.util.Map"%><%@page import="java.util.List"%><%@page import="com.attilax.io.filex"%><%@page import="com.attilax.System.Web.UI.WebControls.DataGridView"%><%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*"%>
<%

//=	
String s7="";
//DataGridView GridView1.DataSource
	String s=filex.read("c:\\dt.txt");
		JSONArray ja= net.sf.json.JSONArray.fromObject(s);
			 
			List li=	(List) request.getSession().getAttribute("wait2confirmDataDetailList");
				JSONArray ja2= CollX.List2jsonArr(li);
		
		DataGridView GridView1 = new DataGridView();
		Object myds = null;
	 
		GridView1.DataSource=ja2;
		GridView1.column="equipmentId";
		GridView1.columnCN="�豸id";

	    //    GridView1.DataKeyNames = new string[] { "id" };//����

	        GridView1.DataBind();
	        	request.getSession().setAttribute("GridView1",GridView1);
	        		request.getSession().setAttribute("GridView2","gv2test");

%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>


<jsp:include page="<%=request.getParameter("tmplt")%>"  flush="true" />
------------------
<!--this for gridview 2-->
<jsp:include page="../../../publish/lookOverdetail_templt2.jsp" flush="true" />

</body>
</html>