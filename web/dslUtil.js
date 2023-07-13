var dslUtil={};

dslUtil.getFldAppFun=function(url)
{
	var json={};
	var keys=urlUtil.getKeys(url);
	for(var i=0;i<keys.length;i++ )
{
	var key=keys[i];
	key=decodeURIComponent(key);
var	key_for_jq=escapeJquery(key);
	//alert(key_for_jq);
	var fun=$("#"+key_for_jq).attr("fun");
	if(fun)
		json[key]=fun;
    
}
return  JSON.stringify(json);
	
};



