// JavaScript Document
// JavaScript Document


function  get_post_intro_success (d){
                    var txt = MI.string.html(String(d)),
                        txt_arr = txt.split('\n'),
                        txt_arr_new =[];//txt.replace(/\n/g, '<br>');
                    for (var i=0,j=txt_arr.length; i<j; i++){
                        (txt_arr[i] != '') && txt_arr_new.push(txt_arr[i])
                    }
                    $('.activeview .movie_page .movie_detail').html(txt_arr_new.join('<br>'));
                  }
//｛“category”:5}
function get_post_intro(txt_file)
{
	var mp="$method=aaaCms.CmsImpLocalFileVer.get_post_intro&$callback=get_post_intro_success&param="+txt_file;
	 //	alert(mp);
		HRE.exe(mp,get_post_intro_success);	
	
}
//function get_posts_callback(data)
//{
// //alert(data);
//	data=str2json(data);
//	try{	
//		 arr=data;
//	//	 gotoPageEvent(1);
//		  
//	  
//	  }catch(e)
//	{
//		showErr(e);	
//	}
//}
function get_posts(paramJsonMap)
{
try{	

		//1:爱情类,2:动画类,3:动作类,4:港台国产,5:剧情类,6:科幻类,7:恐怖类,8:悬疑类,9:战争类,10:喜剧类
	var cate_map={grid0:6,grid1:"爱情类",grid2:"动画类",grid3:"动作类",grid4:"港台国产",grid5:"剧情类",grid6:"科幻类",grid7:"恐怖类",grid8:"悬疑类",grid9:"战争类",grid10:"喜剧类"};
	var cate_cn=cate_map["grid"+paramJsonMap.cate];
	cate_cn=paramJsonMap.cate;
	  	mid=encodeURIComponent( JSON.stringify(paramJsonMap)  );
				
				var meth="aaaDbManager.SqlExecutor.exe";
					meth=encodeURIComponent(meth);
				var mp="$method="+meth+"&$callback=get_posts_callback&sql="+get_posts_sql+"&rdm="+Math.random()+"&param1="+get_posts_sql;
				console.log(mp);
			//	alert("get post mp:"+mp);
				HRE.exe(mp,get_posts_callback);	
}catch(e)
{
	showErr(e);	
}
}


function get_post( id)
{
	
	try{
		var mid= id;
	 
				mid=encodeURIComponent(mid);
				
				var meth="aaaDbManager.SqlExecutor.exe";
					meth=encodeURIComponent(meth);
					get_post_sql=get_post_sql.replace("@id@",id);
				var mp="$method="+meth+"&$callback=get_post_callback&sql="+get_post_sql;
			//	alert("get post mp:"+mp);
				HRE.exe(mp,get_post_callback);	
				return;
			 
	
	
	}catch(e)
	{
		showErr(e);	
	}
}


function query_posts( keyword)
{
	try{
//	alert(keyword);
	var xhr=threadLocalParamMap.xhr;
var fn=threadLocalParamMap.fn;
var err=threadLocalParamMap.err;
//var value=threadLocalParamMap.value;

	if(	window.location.host=="")  //cs envi
			{
			//	mid=encodeURIComponent(mid);
				var mp="$method=aaaCms.CmsImpLocalFileVer.searchV2&$callback=get_posts_callback&param="+keyword;
			//	alert("get post mp:"+mp);
				HRE.exe(mp,get_posts_callback);	
				return;
			}
			else
	 xhr.req({http_param: "select   * from gv_material where material_keyword like '"+keyword+"%'  limit 30 "}, fn, err);
	 
	}catch(e)
	{
	showErr(e);	
	}
}