//  node "D:/prj/spdJs/getLink1.js"
//  node  D:\prj\spdJs\insertDetailinfo.js

//  node  D:\prj\spdJs\dataimgrt.js
//  node  insertDetailinfo.js
// insertDetailinfo.js

// node   D:\prj\spdJs\thumbFix.js




var $;
function imp223() {
    var log4js = require('log4js');
    var mysql = require('mysql');
    const cheerio = require('cheerio')
}

logmdx = require('./jsdk/log.js');
logger = logmdx.logger;
logger.info("this is a info msg");
mdx = require('./conn.js');
connection = mdx.conn;
var fs = require("fs");




const cheerio = require('cheerio');


// sql = "  update movie_t set picture='@tmb@',app_picture='@tmb@',source_id='@vid@' where cache_path = '@url@'  ";
 
// sql = sql.replace(/@tmb@/g, "obj.thumb")
 
// //console.log(sql);
// logger.info(sql);
// throw 'd'


(async () => {


    //for debug 
    // cateid = 12; cate = ''; page = 31
    // fname = "D:\\prj\\data\\hornhub_cate" + cateid + "_page" + page + '.html';
    // logger.info(fname);
    // var html = fs.readFileSync(fname, "utf8");
    // getDetailLinkV2(html, cateid, cate);
    // return;

    for (j = 1; j < 200; j++)
        for (i = 1; i <= 60; i++) {
            // url = 'https://cn.pornhub.com/video?c=80&page=' + i;
            // cateid = 24; 
            cateid = j; cate = '';
            //cate='公众野战';
            page = i;
            fname = "D:\\prj\\data\\hornhub_cate" + cateid + "_page" + page + '.html';
            console.log(fname);
            logger.info(fname)

            try {
                var html = fs.readFileSync(fname, "utf8");

                await getDetailLinkV2(html, cateid, cate);
                logger.info("getDetailLinkV2 after");
            } catch (e) {
                console.log(e)
                logger.error(JSON.stringify(e))
            }
            //   throw 'break'  //for debug

        }
    //end all for   




})();

async function getDetailLinkV2(html, cateid, cate) {

  logger.info("exe fun  getDetailLinkV2")
   // logger.info("cheerio" + cheerio);
    //  logger.info(html);

    $ = cheerio.load(html)
    var li_arr = $('li.pcVideoListItem');


    // //.toArray();

    // for( li of li_arr)
    // {
    //     try {
    //         await li_each_event(0, li)
    //     } catch (e) {
    //         console.error('error: ' + JSON.stringify(e));
    //         console.error(e)
    //     }
    // }
    // // ;.toArray();

var elms=[];
    // var promises = [];

    // //ite note sync 
    await li_arr.each(await async function (index, element) {
        elms.push(element);
        // promises.push(async function () {  

         
        // });


    });


  //  await   Promise.all(promises);

    for( e of elms){

        try {

            await li_each_event(0, e)
        } catch(e) {
            console.error('error: ' + JSON.stringify(e));
            console.error(e)
        }

    }
    


}
async function li_each_event(index, e) {

    logger.log("  li_each_event  start.. "   )
    li_item = e;
    //  logger.info(li_item);
    //title item
    item2 = $(li_item).find('a[class=""]')
    var item = $(li_item).find('a[class=""]').first().toArray()
    item = item[0]
    var item_img = $(li_item).find("img.thumb").first()

    //  item.attr('title')
    //     console.log(item.attribs.href)
    //     console.log(item.attribs.title)

    var obj = {};
    obj.data_video_id = $(li_item).attr('data-id')
    obj.thumb = $(item_img).attr('src');
    obj.cateid = cateid; obj.cate = cate;
    obj.LiAattribs = item.attribs;
    // obj.LiAattribs.title =item.attribs.title;
    // obj.LiAattribs.href = $(  item).attr('href');
    obj.title = item.attribs.title
    obj.href = item.attribs.href
    obj.detailurl = "";
    var obj2str = JSON.stringify(obj);
    //    console.log(obj2str)


    //  child_process.fork("./detailDbInsert.js", [obj2str] ,{silent:true});
    // var cmd = 'node ./detailDbInsert.js ' + escape(obj2str)
    // console.log(cmd)

    try{
  //sql = "INSERT INTO 抓取数据记录(数据,urlid) VALUES('@d@','@urlid@')";
  query = require('./jsdk/mysql.js')
  sql = "  update 抓取数据记录 set 其他扩展字段 = json_set(其他扩展字段,'$.thumb','@tmb@') where urlid = '@url@'  ";
  sql = sql.replace('@url@', '"' + obj.LiAattribs.href + '"')
  sql = sql.replace('@tmb@', obj.thumb)
  logger.info(sql);
  var rzt9 = await query(connection, sql)
  logger.info(rzt9);
  console.log(sql);
    }catch(e)
    {
        logger.error(e);
    }
  


    //update movie
    sql = "  update movie_t set picture='@tmb@',app_picture='@tmb@',source_id='@vid@' where cache_path = '@url@'  ";
    sql = sql.replace('@url@', '' + obj.LiAattribs.href + '')
    sql = sql.replace(/@tmb@/g, obj.thumb)
    sql = sql.replace('@vid@', obj.data_video_id)
    //console.log(sql);
    logger.info(sql);
      rzt9 = await query(connection, sql)
    logger.info(rzt9);
  

  //  process.exit();

}






function getDetailLink(html) {

    var fs = require("fs");



    var html = fs.readFileSync('input.txt.html', "utf8");
    console.log(html);
    const cheerio = require('cheerio')
    const $ = cheerio.load(html)
    var a_arr = $('li a[class=""]').toArray();
    console.log(a_arr)

    for (item of a_arr) {
        console.log(item.attribs.href)
        console.log(item.attribs.title)

    }

}