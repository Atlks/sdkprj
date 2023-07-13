function  getCurPageDatas(list,page,pagesize)
{
	var startIdx=(page-1)*pagesize;
	var endIdx=startIdx+pagesize;
	return list.slice(startIdx,endIdx);
	
	 
}

function  getTotalpage(total,pageSize)
{
	//var startIdx=(page-1)*pagesize;
	var totalpage=Math.ceil(total/pageSize);;
	return  totalpage;
	
	 
}
