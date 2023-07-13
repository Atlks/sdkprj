// JavaScript Document

function getColType(fld,col_def_jsonstr)
{
	var col_def_o=str2json(col_def_jsonstr);
	for(var i=0;i<col_def_o.length;i++)
	{
		var col_def_single_item=col_def_o[i];
		if(col_def_single_item.COLUMN_NAME==fld)
			return col_def_single_item.TYPE_NAME;
		
		
		
	}
	throw "cant find thie fld:"+fld +"in col def:"+ col_def_jsonstr;
	
	
}

function geneLikeExpress(regItemObj,col_def_jsonstr)
{
		var itemx=regItemObj.fld +" " +regItemObj.op+" ";
			itemx=itemx+"'%"+regItemObj.val+"%'";
			return itemx;
		
}
function getWhereItem(regItemObj,col_def_jsonstr)
{
	var itemx=regItemObj.fld;
	itemx=itemx+" " +regItemObj.op+" ";
	
	if(regItemObj.op=="like")
	    return geneLikeExpress(regItemObj,col_def_jsonstr);
	var coltype=getColType(regItemObj.fld,col_def_jsonstr);
	if(coltype=="MEDIUMINT UNSIGNED")
		coltype="num";
	if( coltype=="num")
	{
		itemx=itemx+regItemObj.val;
	}else
		itemx=itemx+"'"+regItemObj.val+"'";
		
		return itemx;
	
}

function getWhereExpressPart4sql(exps_jsonstr,  col_def_jsonstr)
{
	
	
	var reg_arr=str2json(exps_jsonstr);
var sql=" 1=1 ";
for(var i=0;i<reg_arr.length;i++)
{
	var reg=reg_arr[i];
	var where_item=getWhereItem(reg,col_def_jsonstr);	
	sql=sql+" and "+where_item;
	
}
return sql;
}