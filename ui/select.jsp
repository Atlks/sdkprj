<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*"  %>
 <%@page import="java.io.File"%>  
 
  <%@page import="java.util.ArrayList"%>  
   <%@page import="java.util.HashMap"%>  
    <%@page import="java.util.List"%>  
    
     <%@page import="java.util.Map"%>  
      <%@page import="System.Web.UI.WebControls.DropDownList"%>  
      <%@page import="com.attilax.core"%>   
      
<select name="<%=request.getParameter("id")%>" id="<%=request.getParameter("id")%>">
<%
DropDownList ddl= (DropDownList)  session.getAttribute(request.getParameter("DropDownListId") );
List li=ddl.DataSource;

%>

<%= core.toJsonStrO88(ddl)%>
<%
  for (Object object : li) {
			Map m=(Map) object;
			 %>
 	
			
	
<option value="<%=m.get(ddl.DataValueField)%>"><%=m.get(ddl.DataTextField)%></option>
<%  	} %>
</select>