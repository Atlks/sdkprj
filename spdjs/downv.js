

//  <div id="player" class="original mainPlayerDiv" data-video-id="235325351">
//  node "D:/prj/spdJs/getLink1.js"
function imp223()
{
    var log4js = require('log4js');
    var mysql      = require('mysql');
    const cheerio = require('cheerio')
}

logmdx = require('./jsdk/log.js');
logger = logmdx.logger;
logger.info("this is a info msg");
mdx = require('./conn.js');
connection = mdx.conn;
var fs = require("fs");

var  mvarrs=new Array();

for (j=1;j<200;j++)
for (i = 1; i <= 30; i++) {
   // url = 'https://cn.pornhub.com/video?c=80&page=' + i;
   // cateid = 24; 
    cateid=j;cate='';
    //cate='公众野战';
    page = i;
    fname = "D:\\prj\\data\\hornhub" + "_cate" + cateid + "_page" + page + '.html';
    console.log(fname);
    logger.info(fname)

    try{
    var html = fs.readFileSync(fname, "utf8");
 
        getDetailLinkV2(html,cateid,cate);
    }catch(e){
        console.log(e)
        logger.error(e)
    }
   
}



function getDetailLinkV2(html, cateid, cate) {

    var fs = require("fs");



    const cheerio = require('cheerio')
    const $ = cheerio.load(html)
    var a_arr = $('li a[class=""]').toArray();
    console.log(a_arr)
  //  <div id="player" class="original mainPlayerDiv" data-video-id="219486801">
 // var data-video-id = $('#player').atrr('data-video-id');
  
    for (item of a_arr) {
        console.log(item.attribs.href)
        console.log(item.attribs.title)

        var obj = {};
        obj.cateid = cateid; obj.cate = cate; 
        obj.LiAattribs = item.attribs;
        obj.detailurl = "";
        var obj2str = JSON.stringify(obj);
    //    console.log(obj2str)

    mvarrs.push(obj);

    }



}

