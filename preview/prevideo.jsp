<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*" errorPage="" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
#hhh {
	background-color: #666;
	height: 1px;
	width: 620px;
	margin-top: 1px;
}
</style>
</head>

<body>
<%
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
String mediaUrl="../../"+request.getParameter("url");
String mediaUrlAbs=basePath+request.getParameter("url");
String readPlugin=basePath+"upgrd/RealPlayer_16.0.3.51wzbd.exe";
String wid="700";
String hit="500";
String widIE="600";
String hitIE="500";
String ua=request.getHeader("user-agent");

%>

<!--   
.avi .3gp .wmv .rmvb .mov .mp4  .vob
  ||  mediaUrl.endsWith(".3gp")    -->
<!-- avi format-->
<% if(  mediaUrl.endsWith(".avi")    ||  mediaUrl.endsWith(".wmv")    ) {%>
<object classid="CLSID:6BF52A52-394A-11D3-B153-00C04F79FAA6" type="application/x-oleobject"  width="<%=widIE%>" height="<%=hitIE%>" > 
<param name="url" value="<%=mediaUrl%>" /> 
<param name="autostart" value="true" /> 
<param name="showstatusbar" value="true" /> 
<param name="showtracker" value="true" /> 
<param name="showcontrols" value="true" /> 
<param name="uimode" value="full"/> 
<embed   type="application/x-mplayer2"  width="<%=wid%>" height="<%=hit%>"   src="<%=mediaUrl%>">
</embed>
</object> 

<% }else if (   mediaUrl.endsWith(".rmvb") || mediaUrl.endsWith(".rm")     ) { %>
<!-- todox ob8 change 360 browser  to  ie mode -->
<!--set ie8设定要用IE8标准模式渲染网页，而不会使用兼容的模式。-->
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
提示：在360浏览器下，rmvb格式要是急速模式（默认）不能播放,请切换到兼容模式（ie模式）<br />
<div style="display:nonex">
 
  <object id="video" width="600" height=500" border="0" classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA"  archive="<%=readPlugin%>"  codebase="<%=readPlugin%>">

<param name="ShowDisplay" value="1">
<param name="ShowControls" value="1">
<param name="AutoStart" value="1">
<param name="AutoRewind" value="0">
<param name="PlayCount" value="0"> 
<param name="FileName" value="<%=mediaUrl%>">
<param name="SRC" value="<%=mediaUrl%>">
<param name="CONTROLS" value="ImageWindow">
<embed  type="audio/x-pn-realaudio-plugin"  width="<%=wid%>" height="<%=hit%>"     src="<%=mediaUrl%>"    controls='imagewindow,ControlPanel' autostart="true" pluginspage="<%=readPlugin%>" codebase="<%=readPlugin%>"></embed>
</object>
 </div>
 

<% }else if (   mediaUrl.endsWith(".mov")      ) { %>

<!-- cant yeu  showdisplay  showcontrols 的属性。去类zo ok le .-->
提示：如果mov格式不能播放，请把本地址粘贴在kmplayer播放器或者其他支持url方式http流的播放器播放<br>
<%=mediaUrlAbs%><br>
<embed type="application/x-mplayer2"  width="<%=wid%>" height="<%=hit%>"    src="<%=mediaUrl%>" ></embed>



 <% }else if (      mediaUrl.toLowerCase().endsWith(".vob")        ) { %>
 
 <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
 <!--vob fmt    wmv plugin in 360ie mode
 vlc plgin in 360 chorme mode  use by embed
 -->
 <object classid="CLSID:6BF52A52-394A-11D3-B153-00C04F79FAA6" type="application/x-oleobject"  width="<%=wid%>" height="<%=hit%>" > 
<param name="url" value="<%=mediaUrl%>" /> 
<param name="autostart" value="true" /> 
<param name="showstatusbar" value="true" /> 
<param name="showtracker" value="true" /> 
<param name="showcontrols" value="true" /> 
<param name="uimode" value="full"/> 
<embed   type="application/x-mplayer2"  width="<%=wid%>" height="<%=hit%>"      src="<%=mediaUrl%>" ></embed>

</object>
 
<!-- --> 


 <% }else if (      mediaUrl.toLowerCase().endsWith(".mp4")        ) { %>
 <!-- mp4 format   h264,xp,realoneV16 cant play,zaid mp4 fmt nen l .-->
  <object classid="CLSID:6BF52A52-394A-11D3-B153-00C04F79FAA6" type="application/x-oleobject"  width="<%=widIE%>" height="<%=hitIE%>" > 
<param name="url" value="<%=mediaUrl%>" /> 
<param name="autostart" value="true" /> 
<param name="showstatusbar" value="true" /> 
<param name="showtracker" value="true" /> 
<param name="showcontrols" value="true" /> 
<param name="uimode" value="full"/> 
<%if(ua.contains("Windows NT 5.1")){%>
 <embed   type="audio/x-pn-realaudio-plugin"  controls='imagewindow,ControlPanel'    width="<%=wid%>" height="<%=hit%>"      src="<%=mediaUrl%>" ></embed>

<%}else{%>
 <embed   type="application/x-mplayer2"  width="<%=wid%>" height="<%=hit%>"      src="<%=mediaUrl%>" ></embed>
 <%}%>
 </object>
 
 
  <% }else if (      mediaUrl.toLowerCase().endsWith(".3gp")        ) { %>
 <!-- 3gp format  360 chrome mode sh wmp plugin can play
 se zi use embed mode ie10 sh quicktime plugin play
 -->
  <object classid="CLSID:6BF52A52-394A-11D3-B153-00C04F79FAA6" type="application/x-oleobject"  width="<%=widIE%>" height="<%=hitIE%>" > 
<param name="url" value="<%=mediaUrl%>" /> 
<param name="autostart" value="true" /> 
<param name="showstatusbar" value="true" /> 
<param name="showtracker" value="true" /> 
<param name="showcontrols" value="true" /> 
<param name="uimode" value="full"/> 
 <embed   type="application/x-mplayer2"  width="<%=wid%>" height="<%=hit%>"      src="<%=mediaUrl%>" ></embed>
 </object>
 
 
<%} else {%>
<!-- other format-->
<video class="elfinder-quicklook-preview-video" controls="" autoplay="autoplay" preload="auto" autobuffer="" ><source src="../../<%=request.getParameter("url")%>"></video>

<%} %>
<div  id="hhh" style=" width:620px;"></div>
<div style="display:none">os info:
<%=ua%>
</div><br>
<%=mediaUrlAbs%>
</body>
</html>