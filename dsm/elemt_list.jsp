<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" ng-app="atiMod">
 
<head>
<title>素材管理</title>
<!--o88-->
 <script src="../com.attilax/util/datadic_js.jsp"></script>
 <!--///-->
<!--set ie8设定要用IE8标准模式渲染网页，而不会使用兼容的模式。-->
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
<meta http-equiv="description" content="this is my page">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="../resources/css/style.css" type="text/css"></link>
   <%@include file="../common/global_v.jsp" %>
<script type="text/javascript" src="../com.attilax/time/time.js"></script>
<script src="date.js"></script>
<script language="JavaScript" type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>



 <link rel="stylesheet" type="text/css" href="../js/themes/default/easyui.css"/>  
    <link rel="stylesheet" type="text/css" href="../js/themes/icon.css"/>  
	    <link rel="stylesheet" type="text/css" href="../js/demo/demo.css">


 
<script language="JavaScript" type="text/javascript" src="../js/jquery.easyui.min.js">
</script>
<script language="JavaScript" type="text/javascript" src="../js/locale/easyui-lang-zh_CN.js"></script>
 
<script src="js/angular.min.js"></script>

 
 
  <script type='text/javascript' src='../dwr/engine.js'></script>
  <script type='text/javascript' src='../dwr/interface/elmtC.js'></script>

 

  <script type='text/javascript' src='../dwr/util.js'></script>
  <script src="elemt_list_head.js" type="text/javascript"></script>
</head>

<body leftmargin="0" topmargin="0" scrolling="no" style="padding: 0px;">
	<table width="100%" height="100%" id="center-table">
		<tr>
			<td>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="0%" align="left" class="f1"><img
							src="../resources/images/center-lt.gif" /></td>
						<td width="0%" align="right" class="f1"><img
							src="../resources/images/center-rt.gif" /></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="3" valign="top" class="f2">
				<div class="current">
					<div class="l">
						<div class="r">
							<p>
								当前位置：
									<a href="#">视频点播</a> >>素材管理</p>
						</div>
					</div>
				</div>
				<div class="form">
					<div class="l" onclick="toggleElementByDiv('demo1_table2');">
						<div class="r">
							<span>查询</span>
						</div>
					</div>
				</div>
				<form id="formx" name="formx" action="" method="post">
					<table width="100%" class="tab01" id="demo1_table2">
						<tr>
							<td>描述：</td>
							<td style="text-align:left;">
								<input name="materialDescription" type="text" class="input-text" id="materialDescription" value="" />
							</td>
							<td>类型：</td>
							<td class="tdr">
							  <%if("1"=="2"){%>
                <select></select>
                <%}%>
                <!--o88 ati-->
                <d:select DPcode="WJLX"
												tagId="materialType" />
                                                <!-- <%//--include file="cate.html" %>-->
                            
							<td>创建时间：</td>
							<td class="tdr">
								<input type="text" name="createTime" value="" class="input-text  easyui-datebox" style="display:nonex" />
                                
                              
                                
						  </td>
						</tr>
						<tr>
						  <td>播放时长：</td>
						  <td style="text-align:left;"><span class="tdr">
						    <input name="playtime_start"
    required="required" class="easyui-timespinner" id="ss" style="width:80px;" value="00:00:01" data-options="showSeconds:true" />
						  </span>---<span class="tdr">
						  <input name="playtime_end"
    required="required" class="easyui-timespinner" id="ss2" style="width:80px;" value="00:00:01" data-options="showSeconds:true" />
						  </span></td>
						  <td>应用分类：</td>
						  <td class="tdr">
						    <%if("1"=="2"){%>
                <select></select>
                <%}%> <!--o88-->
                                                 <d:select DPcode="appcate"
												tagId="applicationType" />
				<!--<%//--@include file="appcate.html" %>-->
                          
					      <td>&nbsp;</td>
						  <td class="tdr">&nbsp;</td>
					  </tr>
					</table>

					<div class="toolBarDiv">
						<table cellpadding=0 cellspacing=0 width="100%"  border="0"  class="toolBar">
							<tr>
						  		<td>
						    		<table id="toolBar" border="0">
						      			<tr>
											<td class="coolButton" >
												<div style=''>
													<input  type='button' id='id_ev_add' name='ev_add' class='bt00' value='新增' onclick="link_add()"  />
												</div>
											</td>
											<td class="coolButton" ><div style=''><input  type='button'  onclick="editSlktRow()" id='id_ev_edit' name='ev_edit' class='bt00' value='编辑' /></div> </td>
											<td class="coolButton" ><div style=''><input  type='button'   onclick="delxSlktRows()" id='id_ev_del' name='ev_del' class='bt00' value='删除' /></div> </td>
											<td class="coolButton" ><div style=''><input  type='button' onclick="query(1)" id='id_ev_query' name='ev_query' class='bt00' value='查询'/></div> </td>
						            	</tr>
						         	</table>
						      	</td>
						   	</tr>
						</table>
					</div>

					<div class="form">
						<div class="l">
							<div class="r">
								<span>素材管理</span>
								<input type="hidden" name="idsCheckVals" id="idsCheckVals" />
							</div>
						</div>
					</div>

					<table id="tabid1" width="100%" class="tab03"   ng-controller="listCtrl">
						<thead>
							<tr>
								<th>
									<input type="checkbox" onclick="selectAllGrid(this,'checkall')" />
								</th>
								<th>素材id</th>
							 
								<th> 描述</th>
							 
								<th>分类</th>
							 
								<th>应用分类</th>
							 
								<th>播放时长</th>
							 
								<th>创建时间</th>
							 
								<th>生效时间</th>
							 
								<th>失效时间</th>
							 
								<th style="display:none">创建人</th>
							 
								<th class="thr">操作</th>
						  </tr>
					  </thead>
						<tbody id="linkInfoTbody">
							<tr  ng-repeat="itemO7 in listO7" >
								<td>
									<input name="idsCheck" type="checkbox" id="idsCheck" value="{{itemO7.materialId}}" />
								</td>
						 
								<td>{{itemO7.materialId}}</td>
                                	<td>{{itemO7.materialDescription}}</td>
                                    	<td>{{itemO7.materialType|cateFmt}}</td>
                                        <td>{{itemO7.applicationType|appCateFmt}} </td>  <td>{{itemO7.playtime|timefmtSecs}} </td>  <td>{{itemO7.createTime|timeFmtO7}} </td>  <td>{{itemO7.effectieTime|timeFmtO7}} </td>  <td>{{itemO7.failureTime|timeFmtO7}} </td>  <td  style="display:none">{{itemO7.createUser}} </td>
								<td class="tdr">
									<a href="javascript:void(0)" onclick="delx(this.id,this)" id="{{itemO7.materialId}}">
										<img src="../resources/images/delete.gif" onclick="" />&nbsp;&nbsp;&nbsp;
									</a>
									<a href="elemt_edit.jsp?id={{itemO7.materialId}}">
										<img src="../resources/images/alter.gif" />&nbsp;&nbsp;&nbsp;
									</a>
								</td>
							</tr>
			
						</tbody>
					</table>
					<div class="splitPage">
					  <div align="right" class='FormFont'>
					    <script src="pagging.js"></script>
					    共有<span id="totalRows">0</span>条记录&nbsp;&nbsp;&nbsp;&nbsp;
                        <span id="firstPrePageBtnArea">
                        <a href="javascript:firstPage()" id="firstPageBtn">首页</a> &nbsp;<a href="javascript:prePage()" id="prePageBtn">上页</a></span>
                        
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <span id="nextLastPageBtnArea">
                        <a href="javascript:nextPage()" id="nextPageBtn">下页</a> &nbsp;<a href="javascript:lastPage()" id="lastPageBtn">尾页</a></span>&nbsp;&nbsp;&nbsp;输入页码：
					    <input type="text" id="pageItem" size="4" maxlength="5" class="TextStyle"onkeydown="if(event.keyCode==0xD) page_go()">&nbsp;&nbsp;&nbsp;<a href="javascript:page_go()">跳转</a>&nbsp;&nbsp;&nbsp;&nbsp;第<span id="page_page_lab">1</span>页/共<span id="totalPages">10</span>页
                        <span style="display:none">
						  <input name="pagesize" type="hidden" id="pagesize" value="10" />
						  <input name="page_page" type="text" id="page_page" value="1" />
                          </span>
				      <p/></div>
						<!-- <div align="right" class='FormFont'>共有3条记录&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;第1页/共1页<p/> -->
					</div>
				</form>
			</td>
		</tr>
		<tr>
			<td>
				<table width="100%">
					<tr>
						<td align="left" class="f3"><img
							src="../resources/images/center-lb.gif" /></td>
						<td align="right" class="f3"><img
							src="../resources/images/center-rb.gif" /></td>
					</tr>
				</table></td>
		</tr>
	</table>
     <div id="loading"></div> 
   <script>
   function listCtrl($scope) { 

    $scope.listO7 =[ ] ; 

} 

   </script>
      <script type='text/javascript' src='elemt_list.js'></script>
    <script type='text/javascript' src='elemt_list_man.js'></script>
   <script type="text/javascript" defer="defer" src="../resources/js/publicTbody2.js"></script>
</body>
</html>
