<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
   
<%@page import="com.attilax.anno.DataTypeConstants"%>
<%@page import="com.attilax.dsm.Dsmx"%>
<%@page import="com.attilax.biz.Timerang.Name"%>
<%@page import="java.lang.reflect.Field"%>
<html >
  <head>
  <!-- oa9 com.attilax.dsm/tmplt_edit.jsp easyui control in time fmt-->
  <%  String path="";
  String apppath_abs = request.getContextPath();
  path=apppath_abs;
   %>
  <script>var localflag=false;</script>
   
    <title><%=request.getAttribute("tit") %></title>
    <!--set ie8设定要用IE8标准模式渲染网页，而不会使用兼容的模式。-->
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
    <meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
    <meta http-equiv="description" content="this is my page">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="../resources/css/style.css" type="text/css"></link>
      

   <script type="text/javascript" src="../com.attilax/time/time.js"></script>
   <script src="date.js"></script>
    <script type="text/javascript">
function link_back(){
						location.href = "elemt_list.jsp";
					}
    </script>
    
  <!--   ===================easyui start -->  
   <script language="JavaScript" type="text/javascript" src="<%=path%>/js/jquery-1.8.0.min.js"></script>



 <link rel="stylesheet" type="text/css" href="<%=path%>/js/themes/default/easyui.css"/>  
    <link rel="stylesheet" type="text/css" href="<%=path%>/js/themes/icon.css"/>  
	    <link rel="stylesheet" type="text/css" href="<%=path%>/js/demo/demo.css" />


 
<script language="JavaScript" type="text/javascript" src="<%=path%>/js/jquery.easyui.min.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/locale/easyui-lang-zh_CN.js"></script>
   <!--   easyui end  -->  
<!-- ================================dwr start-->
<script>
var dwrxO9="<%=request.getAttribute("dwrx") %>";
</script>
  <script type='text/javascript' src='<%=path%>/dwr/engine.js'></script>
  <script type='text/javascript' src='<%=path%>/dwr/interface/<%=request.getAttribute("dwrx") %>.js'></script>
 
 

  <script type='text/javascript' src="<%=path%>/dwr/util.js"></script>
      <script src="<%=path%>/000com.attilax/json/cycle.js" defer type="text/javascript"></script>  
   
	  
	  <script>
	//  var a={"a":"V"};
	//  alert(a);
	// alert(  JSON.stringify(a) );
	  
	  </script>
    <script>
   function ehO9(msg)
   { alert(msg);
   }
 //   DWREngine.setErrorHandler(ehO9);  jei haosyo dwr2d 
	function errh(errorString, exception) {
	　　//　 alert(errorString);
	　	//	 alert( JSON.stringify(exception));
			eval(dwrxO9).getErr(				function(data){
					// alert(data);
					 window.open("<%=path%>/com.attilax/util/dwrerr.jsp");
					 
			  
				});
}

dwr.engine.setErrorHandler(errh);
  </script>
  
  <!-- dwr end-->
  <!--o7f-->
   <script type='text/javascript' src='<%=path%>/com.attilax/web/req.js'></script>
 
 
 <!--defv spt -->
 <script>
 
 var defv=<%=request.getAttribute("defv") %>;
 </script>
</head>
  
  <body leftmargin="0" topmargin="0" scrolling="no" style="padding:0px; margin:0px">
		<table width="100%" height="100%" id="center-table">
        <tr>
          <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="0%" align="left" class="f1"><img src="../resources/images/center-lt.gif" /></td>
              <td width="0%" align="right" class="f1"><img src="../resources/images/center-rt.gif" /></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td colspan="3" valign="top" class="f2"><div class="current">
            <div class="l">
              <div class="r">
                <p> 当前位置：>><%=request.getAttribute("tit") %></p>
              </div>
            </div>
          </div>
            <div class="form">
              <div class="l">
                <div class="r"><span><%=request.getAttribute("tit") %></span></div>
              </div>
            </div>
            <form action="" method="post" enctype="multipart/form-data" name="formx" id="formx">
            <table width="100%" class="tab01" id="demo1_table">
            <tbody>
            
            <%
            Field[] flds =( Field[] ) request.getAttribute("flds");
	 
            	for (Field field : flds) {
					//fld name
            	Name nm=field.getAnnotation(Name.class);
				String lableText=field.getName();
				if(nm!=null)
				   lableText=nm.value();
				
				
//			if(field.getType()==Timestamp.class)
//			{
//				
//			}
//		}
             %>
              <tr>
                <td width="130"><span class="required"></span><span class="required">*</span><%=lableText %>：</td>
                <td class="tdr">
              <!-- 
                <input name="effectieTime" type="text" class="input-text easyui-datetimebox" id="effectieTime"  data-options="formatter:formatDateTextO7"  formatter="formatDateTextO7">
                --> 
                <%
                	String datatype=Dsmx.getDatatype(field);
		if(datatype.equals(DataTypeConstants.time))
		{
                 %>
                   <input name="<%=field.getName() %>"
    required="required" class="easyui-timespinner" id="<%=field.getName() %>" style="width:188px;" value="" data-options="showSeconds:true">
                <%}else{ %>
                
                 <input name="<%=field.getName() %>"
    required="required"   id="<%=field.getName() %>" style="width:188px;" value="" data-options="showSeconds:true">
                  <%}  %>
                </td>
</tr>
<%} %>
<tr>
  <td colspan="2" class="tdb tdr"><table cellpadding=0 cellspacing=0 width="100%"  border="0"  class="toolBar">
    <tr>
      <td><table id="toolBar" border="0">
        <tr>
          <td class='coolButton' align='left' width='0'></td>
          <td class="coolButton" ><div style=''>
            <input  type='button' id='id_ev_add' name='ev_add' class='bt00' value='保存' onClick=" save()" />
            </div></td>
          <td class="coolButton" ><div style=''>
            <input  type='button' id='btnCancelO09' name='btnCancelO09' class='bt00' value='取消' onclick=""  />
            </div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
</tr>
</tbody>
</table>
</form>
</td>
</tr>
<tr>
  <td><table width="100%">
    <tr>
      <td align="left" class="f3"><img src="../resources/images/center-lb.gif" /></td>
      <td align="right" class="f3"><img src="../resources/images/center-rb.gif" /></td>
    </tr>
  </table></td>
</tr>
</table>
  <script src="elemt_edit.js" type="text/javascript"></script>
</body>
</html>
