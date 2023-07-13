//  node "D:/prj/spdJs/getLink1.js"
//  node  D:\prj\spdJs\insertDetailinfo.js

//  node  insertDetailinfo.js
// insertDetailinfo.js

maindir = 'D:\\prj\\dataCateTest';
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

(async () => {
    //for debug 
    // cateid = 12; cate = ''; page = 31
    // fname = "D:\\prj\\data\\hornhub_cate" + cateid + "_page" + page + '.html';
    // logger.info(fname);
    // var html = fs.readFileSync(fname, "utf8");
    // getDetailLinkV2(html, cateid, cate);
    // return;

    for (j = 23; j < 200; j++)
        for (i = 60; i <= 500; i++) {
            // url = 'https://cn.pornhub.com/video?c=80&page=' + i;
            // cateid = 24; 
            cateid = j; cate = '';
            //cate='公众野战';
            page = i;
            fname = maindir+"\\hornhub_cate" + cateid + "_page" + page + '.html';
            console.log(fname);
            logger.info(fname)

            try {
                var html = fs.readFileSync(fname, "utf8");

                await getDetailLinkV2(html, cateid, cate);
            } catch (e) {
                console.log(e)
                logger.error(e)
            }

        }

})();

var $;
async function getDetailLinkV2(html, cateid, cate) {

    var fs = require("fs");



    const cheerio = require('cheerio')
    logger.info(cheerio);
    //  logger.info(html);

    $ = cheerio.load(html)

    var li_arr = $('li.pcVideoListItem');


    var elms = [];

    await li_arr.each(await async function (index, element) {
        elms.push(element);

    });


    //  await   Promise.all(promises);

    for (e of elms) {

        try {

            await li_each_event(0, e)
        } catch (e) {
            console.error('error: ' + JSON.stringify(e));
            console.error(e)
        }

    }





}


async function li_each_event(index, e) {

    logger.log("  li_each_event  start.. ")
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


    try {
        //sql = "INSERT INTO 抓取数据记录(数据,urlid) VALUES('@d@','@urlid@')";
        query = require('./jsdk/mysql.js')

        sql = "INSERT INTO 抓取数据记录(数据,urlid) VALUES('@d@','@urlid@')";
        sql = sql.replace('@urlid@', '"' + obj.LiAattribs.href + '"')
        sql = sql.replace('@d@', obj2str)
        // console.log(sql);
        //sql = "  update 抓取数据记录 set 其他扩展字段 = json_set(其他扩展字段,'$.thumb','@tmb@') where urlid = '@url@'  ";
        //   sql = sql.replace('@url@', '"' + obj.LiAattribs.href + '"')
        //   sql = sql.replace('@tmb@', obj.thumb)
        logger.info(sql);
        var rzt9 = await query(connection, sql)
        logger.info(rzt9);
        console.log(sql);
    } catch (e) {
        logger.error(e);
    }




    sql_istMv = "insert movie_t(id,movie_name,description,create_time,source_site_code,cache_path,picture,app_picture,source_id)values('@id@',    '@t@'  ,'@desc@' ,now(),'pornhub',  '@url@' ,'@tmb@','@tmb@','@vid@'  );"


    sql_istMv = sql_istMv.replace('@id@', new Date().getTime());
    sql_istMv = sql_istMv.replace('@desc@', obj2str);
    json = JSON.parse(obj2str)
    try { sql_istMv = sql_istMv.replace('@t@', json.LiAattribs.title) } catch (e) { }
    try { sql_istMv = sql_istMv.replace('@url@', json.LiAattribs.href) } catch (e) { }
    sql_istMv = sql_istMv.replace(/@tmb@/g, obj.thumb)
    sql_istMv = sql_istMv.replace('@vid@', obj.data_video_id)
    logger.info(sql_istMv);
    //   throw 'die'
    var rzt9 = await query(connection, sql_istMv)
    logger.info(rzt9);


    //update movie
    // sql = "  update movie_t set picture='@tmb@',app_picture='@tmb@',source_id='@vid@' where cache_path = '@url@'  ";
    // sql = sql.replace('@url@', '' + obj.LiAattribs.href + '')
    // sql = sql.replace(/@tmb@/g, obj.thumb)
    // sql = sql.replace('@vid@', obj.data_video_id)
    // //console.log(sql);
    // logger.info(sql);
    // rzt9 = await query(connection, sql)
    // logger.info(rzt9);


    // process.exit();
    // throw 'ex'

}

//@dep
function xx() {


    var a_arr = $('li a[class=""]').toArray();
    //  console.log(a_arr)
    //  <div id="player" class="original mainPlayerDiv" data-video-id="219486801">
    // var data-video-id = $('#player').atrr('data-video-id');
    child_process = require('child_process')

    for (item of a_arr) {

        try {
            console.log(item.attribs.href)
            console.log(item.attribs.title)

            var obj = {};
            obj.cateid = cateid; obj.cate = cate;
            obj.LiAattribs = item.attribs;
            obj.detailurl = "";
            var obj2str = JSON.stringify(obj);
            //    console.log(obj2str)


            //  child_process.fork("./detailDbInsert.js", [obj2str] ,{silent:true});
            var cmd = 'node ./detailDbInsert.js ' + escape(obj2str)
            console.log(cmd)

            sql = "INSERT INTO 抓取数据记录(数据,urlid) VALUES('@d@','@urlid@')";
            sql = sql.replace('@urlid@', '"' + obj.LiAattribs.href + '"')
            sql = sql.replace('@d@', obj2str)
            console.log(sql);
            var fs = require("fs");
            fs.appendFileSync('insertDetail.sql', sql + ";\r\n")
            // fs.appendFile('insertDetail.sql', sql + ";\r\n", function (err) {
            //     if (err) throw err;
            //     logger.info('The "data to append" was appended to file!' + sql);
            //     //数据被添加到文件的尾部
            //   //  console.log();
            // });
            // child_process.exec(cmd, function (error, stdout, stderr) {
            //     if (error) {
            //         console.error('error: ' + error);
            //         return;
            //     }
            //     console.log('stdout: ' + stdout);
            //     console.log('stderr: ' + typeof stderr);
            // });
        } catch (e) {
            console.error('error: ' + e);
        }
    }

}

// @dep
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