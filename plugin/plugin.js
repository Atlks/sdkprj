// JavaScript Document
var pluginsAti={};
function FilterFilterChain()
{
this.filter;
this.next;	
	
}
function add_action(hookPoint,func)
{
	
	if(pluginsAti.hookPoint==undefined)
	{
	pluginsAti.hookPoint = new Array();
	}
	
	pluginsAti.hookPoint.push(func);	
}

//  fltFinishCallback for ajax  ..if sync invoke ,,cant neccesury
function do_action(hookPoint,args,fltFinishCallback)
{
	var fltChain=new FilterFilterChain();
	var firstChain;
//	var curFltChain;
	var lastFltChain;
	var fun_arr=pluginsAti.hookPoint;
	//	for (var fn in fun_arr)  
		for (var i=0; i < fun_arr.length; i++) {
    
			var myChain=  new FilterFilterChain();
			myChain.filter=fun_arr[i];
			
			
			
			if(lastFltChain!=null)
			{
				lastFltChain.next=myChain;
				
			}			
			lastFltChain=myChain;
			
			
			if(firstChain==null)
			{
				firstChain=myChain;
			}
			//curFltChain.next=
//			if(curFltChain==null)
//			curFltChain=new FilterFilterChain();
//			curFltChain
//			fltChain.next=
		}
  		//  fn(mp);
		doFilter(args,firstChain,fltFinishCallback);
	
}

function doFilter(data,nextChain,fltFinishCallback)
{
	if(nextChain!=null)
		nextChain.filter(data,nextChain.next,fltFinishCallback);
		else
		fltFinishCallback(data);
	
}