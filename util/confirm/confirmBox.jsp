<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*"%>
<%@page import="com.attilax.util.DateUtil"%><%@page import="com.attilax.collection.CollX"%><%@page import="java.util.HashMap"%><%@page import="com.attilax.dsm.BaseSvsO9o4Cri"%><%@page import="com.attilax.Stream.Mapx"%><%@page import="net.sf.json.JSONArray"%><%@page import="java.util.Map"%><%@page import="java.util.List"%><%@page import="com.attilax.io.filex"%><%@page import="com.attilax.System.Web.UI.WebControls.DataGridView"%><%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*"%>
<%

//=	
String s7="";
//DataGridView GridView1.DataSource
//----for test
//	String s=filex.read("c:\\confirmboxdata\\1125_173843_472.txt");
//		JSONArray ja= net.sf.json.JSONArray.fromObject(s);
			 
		List li=	(List) request.getSession().getAttribute("wait2confirmDataDetailList");
		JSONArray ja= CollX.List2jsonArr(li);
		
		List li1=	(List) request.getSession().getAttribute("wait2confirmDataDetailList1");
		JSONArray ja1= CollX.List2jsonArr(li1);
		
		DataGridView GridView1 = new DataGridView();
		DataGridView GridView3 = new DataGridView();
		//Object myds = null;
	 
		GridView1.DataSource=ja;
		GridView1.column="equipmentId";
		GridView1.columnCN="�豸id";
		
		GridView3.DataSource=ja1;
		GridView3.column="equipmentId";
		GridView3.columnCN="id";

	    //    GridView1.DataKeyNames = new string[] { "id" };//����

	        GridView1.DataBind();
	        GridView3.DataBind();
	        	request.getSession().setAttribute("GridView1",GridView1);
	        	request.getSession().setAttribute("GridView2","gv2test");
	        	request.getSession().setAttribute("GridView3",GridView3);

%>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<%

%>
<script type="text/javascript">
function cancel()
{
	 window.close();
}
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
</script>
<style type="text/css">
body {
	margin-left: 25px;
	margin-right: 25px;
}
</style>
</head>

<body style="background: #FFF; padding: 25px; ">
 
<p><strong  style="color: #F00;  font-weight:bold; font-size:14px;display:none">提醒：您发布的节目单有以下门店在此时间范围内已发布了节目单,请谨慎发布,继续发布请点击确认,否则请取消：：<br />
    <br>
</strong>  <a style="display:none" href="lookOverdetail.jsp?tmplt=<%=request.getParameter("tmplt")%>" target="_blank">  查看
  详细 </a>
<!--http://192.168.1.33/vod//com.attilax/util/confirm/confirmBox.jsp?confmEveHandle=window.opener.confirmSubmitBackeventHandle&tmplt=/publish/grid_templt.jsp-->
  <input name="button" type="button" id="button" onclick="<%=request.getParameter("confmEveHandle")%>(); window.close();" value="确认提交" />
  <input name="button2" type="button" id="button2" onclick="cancel()" value="取消提交" />
    <input name="button2" type="button" id="button2" onclick="obb()" value="取消提交"  style="display:none"/>
    <script>
	function obb()
	{
		window.open("/vod/publish/t.html");
	}
	
	
	</script>
  <br/>
  <br/>
 </p>
<p style="font-weight:bold; font-size:18px;display:none">发布时间段：<%=request.getParameter("startTime")%> ---- <%=request.getParameter("endTime")%></p> 


<p>
  <jsp:include page='<%=request.getParameter(\"tmplt\")%>'  flush="true" />
 
  <jsp:include page='<%=request.getParameter(\"tmplt1\")%>'  flush="true" />
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp; </p>
</body>
</html>
