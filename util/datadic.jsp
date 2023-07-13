<%@ page contentType="text/html; charset=utf-8" language="java" import="java.sql.*"  %>
<script >
var cateO88=<jsp:include page="/spr/ajaxDictionaryList"  flush="true"  >
<jsp:param name="cate"value="WJLX"/>
</jsp:include>;

var appcateO88=<jsp:include page="/spr/ajaxDictionaryList?cate=appcate" flush="true"   />;

</script>