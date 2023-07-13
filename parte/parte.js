// JavaScript Document

function formatPartE(s,title)

{

var r=title;

var   data = eval(  "(" + s + ")"   );

//    for (var eItem in data)

  for(var i=0; i<data.length; i++)  

    {

var eItem=data[i];

r=r+"\r\n"+"数据id:"+eItem.id +"    提示："+eItem.msg;

}

return r;

}