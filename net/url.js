// JavaScript Document

function getQueryStr()
{
	var url=location.search;
   var str = url.substr(1);
   return str;
};


function url2dirname(url)
{

    var    url_tmp = url.replace("http://", "");
    url_tmp = url_tmp.replace("https://", "");
    url_tmp = url_tmp.replace(/\//g, "%2f");
    url_tmp = url_tmp.replace(/\\/g, "%5c");
    return url_tmp;
}
/*
*


var response_timer = setTimeout(function() {
    try{
        if(req_ClientRequest)
            req_ClientRequest.destroy();
        console.log('Response Timeout.');
    }catch(e)
    {
        console.log(e);
    }

}, 5000)* */;