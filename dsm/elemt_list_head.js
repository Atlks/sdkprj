
	function link_add(){
		location.href = "elemt_edit.jsp";
	}



   var homeModule = angular.module("atiMod", []);
	//homeModule.filter('timeFmtO7', function(input) {
//		//  var titleCaseFilter="aa";
//		alert(input);
//		  return "aa";
//		});
homeModule.filter('timeFmtO7',function(){
    return function(item){
		try{
        return item.Format("yyyy-MM-dd hh:mm:ss");
		}catch(e){return "";}
    }
});  
homeModule.filter('cateFmt',function(){
    return function(item){
		//var json={"2":"视频","1":"图片","3":"文本"};
		//todox o7d must use collect mode ,if use json.item ,ret empty..
	//	alert(cateO88);
        return  cateO88[item];
    }
});  
homeModule.filter('appCateFmt',function(){
    return function(item){
     //   var json={"5":"宣传片","1":"广告","2":"促销","3":"公告","4":"庆典"};
		//todox o7d must use collect mode ,if use json.item ,ret empty..
        return  appcateO88[item];
    }
});  

homeModule.filter('timefmtSecs',function(){
    return function(item){
		try{
        return secs2str(item);
		}catch(e){return "";}
    }
}); 
  
  

