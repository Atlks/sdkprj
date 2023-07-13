/**
 * Created by Administrator on 2017/6/1.
 */


function getAllLink(html)
{

   var jsdom = require("jsdom");
  //  console.log(jsdom)

    var window = jsdom.jsdom(html).defaultView;
//var   $ = require("jquery")(jsdom.jsdom().defaultView);
// var   $ = require("jquery")( jsdom.jsdom().createWindow() );

    //only low ver can this
 //  var $ = require('jquery');


  //  var   $ = jsdom.jsdom().createWindow(),

    var $ = require('jquery');
    var $doc = $(html);
    $doc.find("a").each(function(i,project) {
        var $project = $(project);
        console.log($project.attr("href") )
    });

}
var libpath=__dirname+"/../";
var pathUtil = require(libpath+"io/path.js");
var strModule = require(libpath+"text/str.js");
function getcontentJson(content){
   var json={};
    var a=content.split(";");
    for(item of a)
    {
        var a2=item.split("=");
        var key=a2[0];
       key=strModule.trim(key);
         json[key]= a2[1];
    }
    return json;

}
function getEncode(html_utf8)
{
    var cheerio=require('cheerio');
    var $=cheerio.load(html_utf8);
   var charset="utf8";
    var e_list = $('meta');
    console.log("links len:"+e_list.length)
    e_list.each(function(i,item) {

      //  var cap = $(this);
        //     var $project = $(project);
      //  console.log( "http-equiv   "+  $(item).attr("http-equiv"))
    //    console.log( "content  "+ $(item).attr("content") )
        if(  $(item).attr("http-equiv")=="Content-Type" )
        {
           console.log(  "---" +$(item).attr("content") )

            content=$(item).attr("content");
            var content_json=getcontentJson(content);
            if(content_json.charset )
                charset=content_json.charset;
            }
            if(  $(item).attr("charset")  )
                charset=$(item).attr("charset");
      //   console.log( $(item).attr("charset") )
      //  console.log( $(item).attr("content") )
     //   content
        var obj=$(item);

        //html is empty
     //   console.log( $(item).html() )
    //    console.log(  "this html:"+$(this).html() )
        //    console.log(JSON.stringify( item))
    });
  //  console.log( $(item).text() )
   // if(charset!="")
    return charset;
}

var iconv = require('iconv-lite');
function getAllLink_byc_heerio(html)
{
var a=new Array();
    var cheerio=require('cheerio');
    var $=cheerio.load(html);

    var links = $('a');
    links.each(function(i,item) {

        var cap = $(this);
   //     var $project = $(project);
        console.log( $(item).attr("href") )
        console.log( $(item).text() )
        var o={};
        o.href= $(item).attr("href");
        o.text=    strModule.trim( $(item).text() );
    //    console.log(JSON.stringify( item))
        a.push(o)
    });
return a;
}

function getHTML(f)
{
    var html="";
    var fs = require('fs');

    console.log(f)
    var data_utf = fs.readFileSync(f,"utf8");
    var encode=getEncode(data_utf);
    console.log(" getEncode: "+encode)
    if(encode=="utf8" || encode=="utf-8")
        html=data_utf;
    else
    {
        var stdout_data = fs.readFileSync(f);
          html = iconv.decode(stdout_data,encode);
    }
    return html;
}


function getHTML_binaryData(stdout_data)
{
    var html="";
   // html =
  var data_utf = iconv.decode(stdout_data,"utf8");
    var encode=getEncode(data_utf);
    console.log(" getEncode: "+encode)
    if(encode=="utf8" || encode=="utf-8")
        html=data_utf;
    else
    {
       // var stdout_data = fs.readFileSync(f);
        html = iconv.decode(stdout_data,encode);
    }
    return html;
}

//var f="C:\\00orgSave\\url%www.51cto.com%2f_1496298576049.html";
//var html=getHTML(f);
exports.getHTML_binaryData = getHTML_binaryData;
exports.getAllLink_byc_heerio = getAllLink_byc_heerio;
 //getAllLink_byc_heerio(html);


//getEncode(data_utf)