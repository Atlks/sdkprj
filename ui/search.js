// JavaScript Document
function searchBoxClick()
{
   var str=prompt("请输入要搜索词拼音缩写","");
    if(str)
    {
      //  alert("您刚输入的是："+ str)
		query_posts(str);
    }
}