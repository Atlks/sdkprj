/**
 * Created by Administrator on 2017/1/14.
 */
var sys = require("util");
var fs = require('fs');
sys.log("Hello world");
var libpath=__dirname+"/../";
var pathUtil = require(libpath+"io/path.js");
var strModule = require(libpath+"text/str.js");
var timeUtil = require(libpath+"time/time.js");
var httpModule= require('http');
var http= require('http');
var ArrayUtil = require(libpath+"util/ArrayUtil.js");
var https = require("https");
var HtmlParser = require(libpath+"html/HtmlParser.js");
var fileUtilAti = require(libpath+"io/fileUtil.js");
//D:\0workspace\atiplat_eeJS\com.attilax\html\HtmlParser.js
/**
 * from dir
 * @returns {Array}
 */
function getUrls()
{
    start_dir="D:\\0workspace\\atiplat_eeJS\\reader_url_cfg";
    var filM = require(libpath+"io/fileUtil.js");
    var fls=filM.getFileListV2(start_dir);
    var urls2=new Array();
    for( f_obj of fls)
    {
        var file_fullpath= f_obj.path+"\\"+f_obj.filename;
        var urls_tmp=getUrls_from_file( file_fullpath);
        urls2= ArrayUtil.concat(urls2,urls_tmp);
        console.log("")
    }


    return urls2;
}

function  getUrls_from_file( file_fullpath)
{
    var a=new Array();
    var data = fs.readFileSync(file_fullpath, 'utf8');
    var lines=data.split("\n");
    for(line of lines)
    {
        line=strModule.trim(line);
        if(line.length==0)
        continue;
        a.push(line);

    }
    return a;


}

//main
function  main()
{
    var urls=getUrls();
    var cnt=0;
    for(idx in urls)
    {
        var url=urls[idx];
        console.log("url:"+url);
        cnt++;


        try{
            req4siteurl(url,cnt,res4sitehtml);
        }catch(e)
        {
            console.log( url +e);
        }

    }
}
function url2dirname(url)
{

    var    url_tmp = url.replace("http://", "");
    url_tmp = url_tmp.replace("https://", "");
    url_tmp = url_tmp.replace(/\//g, "%2f");
    url_tmp = url_tmp.replace(/\\/g, "%5c");
    return url_tmp;
}


/*
 * for html
 *
 * */

function req4siteurl(url,url_cnt_idx,resAftEvt,encode)
{
    var httpModtmp=http;
    if( url.indexOf("https://")>=0 )
        httpModtmp=https;
//    console.log(" start req:"+url +" cnt:"+url_cnt_idx);
    if(url.indexOf("http://")==-1 &&  url.indexOf("https://")==-1 )
        url="http://"+url;


    console.log(" start req final:"+url +" ,cnt:"+url_cnt_idx);


    try {
        //get 请求外网
        var   req_ClientRequest =  httpModtmp.get(url, function (res) {
            res.setEncoding("binary"); //一定要设置response的编码为binary否则会下载下来的图片打不开
            var data = '';
            res.on('data', function (chunk) {
                data += chunk;
            });
            res.on('end', function () {
                //   console.info(html);

                resAftEvt(url,url_cnt_idx,data );

            });
        });  //end   httpModtmp.get

        //  if(httpModtmp==http)
        req_ClientRequest.on('error', function(e) {
            console.error(" req err:"+ url+ JSON.stringify(e));
        });
    }catch(e)
    {
        console.error( url+  e);
    }


}

function filtTooshortTextLinks(lins){
    var a=[];
    for( lk of lins)
    {
        if(lk.text.length>10)
            a.push(lk);
    }
return a;
}


//D:\0workspace\atiplat_eeJS\com.attilax\html\HtmlParser.js
function res4sitehtml(url, url_idx, data)
{
    let    url_tmp = url.replace("http://", "");
    url_tmp = url_tmp.replace("https://", "");
    url_tmp = url_tmp.replace(/\//g, "%2f");
    url_tmp = url_tmp.replace(/\\/g, "%5c");

    var savepath = 'c:\\00orgSave\\url%' + url_tmp + "_" + timeUtil.getTimestamp() + '.html';
    console.log("savepath:"+savepath)
    pathUtil.mkdirsSync_byfilepath(savepath);
    fs.writeFileSync(savepath, data, "binary");
  //  fs.writeFileSync(savepath, data);

    var html=HtmlParser.getHTML_binaryData(data);
   var links= HtmlParser.getAllLink_byc_heerio(html)
    links=filtTooshortTextLinks(links);

       //getUrls_fromHtml(html);
   for( let link of links)
   {

       try{
           req_file(link.href,0,function(link_url,link_idx,bin_data)
           {
               var sub_dir_name=url_tmp;
var  fname=fileUtilAti.fileNameEncode(  link.text )


               var savepath = "c:\\00orgSave\\"+sub_dir_name + "\\"+fname+"_" + timeUtil.getTimestamp() + '.html';
               console.log( savepath)
               pathUtil.mkdirsSync_byfilepath(savepath);
               var opt={encoding:"binary",mode: 777, flag: 'w'};
               fs.writeFileSync(savepath, bin_data,opt);

           });//end req file
       }catch(e)
       {
           console.error(e);
       }



   }  //end for

}

/**
function res4pagefile(url, url_idx, data)



    var savepath = 'c:\\00orgSave\\url%' + url_tmp + "_" + timeUtil.getTimestamp() + '.html';
    console.log("savepath:"+savepath)
    pathUtil.mkdirsSync_byfilepath(savepath);
    fs.writeFileSync(savepath, data, "binary");


}
*/


function req_file(url,url_cnt_idx,resAftEvt)
{
    var httpModtmp=http;
    if( url.indexOf("https://")>=0 )
        httpModtmp=https;
//    console.log(" start req:"+url +" cnt:"+url_cnt_idx);
    if(url.indexOf("http://")==-1 &&  url.indexOf("https://")==-1 )
        url="http://"+url;


    console.log(" start req final:"+url +" ,cnt:"+url_cnt_idx);


    try {
        //get 请求外网
        let   req_ClientRequest =  httpModtmp.get(url, function (res) {
            res.setEncoding("binary"); //一定要设置response的编码为binary否则会下载下来的图片打不开
            var data = '';
            res.on('data', function (chunk) {
                data += chunk;
            });
            res.on('end', function () {
                        resAftEvt(url,url_cnt_idx,data);
                        //  clearTimeout(request_timer);

            });
        });  //end   httpModtmp.get

        //  if(httpModtmp==http)
        req_ClientRequest.on('error', function(e) {
            //  clearTimeout(request_timer);
            console.error(" req err:"+ url+ JSON.stringify(e));
        });

        req_ClientRequest.setTimeout(1000, function(){
            console.log('timeout!');
        });
        let req=req_ClientRequest;
        req.setTimeout(60000);
        req.on('socket', function(socket){
            socket.on('timeout', function(){
                // timeout exceed
                console.log('timeout r61!');
            });
        });

        // 等待响应60秒超时
        var response_timer = setTimeout(function() {
            try{
                if(req_ClientRequest)
                req_ClientRequest.destroy();
                console.log('Response Timeout.');
            }catch(e)
            {

            }

        }, 60000);
    }catch(e)
    {
        console.error( url+  e);
    }


}


/*
*/




  main()

// req_httpNhttps( "http://www.yuecang.com/tech/",1);
//req4siteurl( "http://www.51cto.com",1, res4sitehtml);

 var f="C:\\00orgSave\\url%www.51cto.com%2f_1496298576049.html";
//var stdout_data = fs.readFileSync(f);
//res4sitehtml( "http://www.51cto.com",1, stdout_data);
//"http://www.51cto.com",1, res4sitehtml