// JavaScript Document

function yaml2json(catesQ319)
{
var map={};
var a=	catesQ319.split(",");
for(i=0;i<a.length;i++)
{
  var itemx=a[i];
  var a2=itemx.split(":");
  map[i]=a2[1];
  	
}
	return map;
}

//q42
function yaml2jsonV2(catesQ319)
{
var map={};
var a=	catesQ319.split(",");
for(i=0;i<a.length;i++)
{
  var itemx=a[i];
  var a2=itemx.split(":");
  map[a2[0]]=a2[1];
  	
}
	return map;
}