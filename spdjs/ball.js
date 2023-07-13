obj = { "f1": 1, "f2": 2 }
for (var fld in obj) {

    console.log(fld, ":", obj[fld]);

}

//return;

logmdx = require('./jsdk/log.js');
logger = logmdx.logger;
console.log("--");

mdx = require('./connBall.js');
connection = mdx.conn;
query = require('./jsdk/mysql.js')


flds = 'id,area_id,country_id,name_zh,short_name_zh,name_zht,short_name_zht,name_en,short_name_en,logo'
arr = flds.split(',')
placehodr_arr = []
for (fld of arr) {
    var fs = require("fs");
    tmp = fs.readFileSync('./jsdk/rplsTmp.txt', "utf8")

    tmp = tmp.replace('#fld#', fld);
    tmp = tmp.replace('#fld#', fld)
    console.log(tmp);


}

console.log(placehodr_arr.join(','));

/**
 * 
 *  id: 1,
  area_id: 3,
  country_id: 54,
  name_zh: '美国男子职业篮球联赛',
  short_name_zh: 'NBA',
  name_zht: '美國男子職業籃球聯賽',
  short_name_zht: 'NBA',
  name_en: 'National Basketball Association',
  short_name_en: 'NBA',
  logo: 'https://cdn.sportnanoapi.com/basketball/competition/aa6ac10ab514aba38a86c57d34e64f31.jpg'
 * 
 */
(async () => {

    // Match_list()
    //  team_list()
    //  Match_list()
  //  countrys_list();
    areas_list();
})();

async function team_list() {
    var json = await getJsonRzt('Basketball.Live.Match_list')

    for (var fld in json.data.teams) {
        // for (item of json.data.teams) {

        id = fld;
        item = json.data.teams[fld];

        try {
            logger.info(item);

            //unique
            uniqueIdx("basketball_team_t", "id", id);

            sql = 'insert  into basketball_team_t(  id,name_zh,short_name_zh,name_zht,short_name_zht,name_en,short_name_en,logo   )values( @id@,@name_zh@,@short_name_zh@,@name_zht@,@short_name_zht@,@name_en@,@short_name_en@,@logo@)';


            sql = sql.replace('@id@', "'" + item.id + "'")


            sql = sql.replace('@name_zh@', "'" + item.name_zh + "'")

            sql = sql.replace('@short_name_zh@', "'" + item.short_name_zh + "'")

            sql = sql.replace('@name_zht@', "'" + item.name_zht + "'")

            sql = sql.replace('@short_name_zht@', "'" + item.short_name_zht + "'")

            sql = sql.replace('@name_en@', "'" + item.name_en + "'")

            sql = sql.replace('@short_name_en@', "'" + item.short_name_en + "'")

            sql = sql.replace('@logo@', "'" + item.logo + "'")


            logger.info(sql);
            var rzt = await query(connection, sql)
            logger.info(rzt);



        } catch (e) {
            logger.error(e);

        }
        // break;
        //    break;
        //   process.exit();
    }

    //   basket_match_event_t

    console.log("f");
}

/**
 * `id` bigint(32) unsigned NOT NULL COMMENT '比赛id',
  `match_event_id` bigint(32) NOT NULL COMMENT '赛事id',
  `total_sections` int(4) NOT NULL COMMENT '比赛总节数',
  `match_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT '篮球状态码	描述	\r\n0	比赛异常，说明：暂未判断具体原因的异常比赛，可能但不限于：腰斩、取消等等，可隐藏处理	篮球比赛状态\r\n1	未开赛	篮球比赛状态\r\n2	第一节	篮球比赛状态\r\n3	第一节完	篮球比赛状态\r\n4	第二节	篮球比赛状态\r\n5	第二节完	篮球比赛状态\r\n6	第三节	篮球比赛状态\r\n7	第三节完	篮球比赛状态\r\n8	第四节	篮球比赛状态\r\n9	加时	篮球比赛状态\r\n10	完场	篮球比赛状态\r\n11	中断	篮球比赛状态\r\n12	取消	篮球比赛状态\r\n13	延期	篮球比赛状态\r\n14	腰斩	篮球比赛状态\r\n15	待定	篮球比赛状态',
  `match_time` bigint(15) unsigned NOT NULL DEFAULT '0' COMMENT '比赛时间',
  `current_total_seconds` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '当前总秒钟数，显示转换成 mm:ss',
  `season_id` bigint(32) NOT NULL DEFAULT '0' COMMENT '赛季id',
  `match_detail` varchar(100) NOT NULL COMMENT '比赛详细说明',
  `compatible` varchar(100) NOT NULL COMMENT '兼容,请忽略',
  `animation` int(4) NOT NULL DEFAULT '0' COMMENT '是否有动画，未购买客户请忽略',
  `intelligence` int(4) NOT NULL DEFAULT '0' COMMENT '是否有情报，未购买客户请忽略',
  `create_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `delete_flag` char(1) NOT NULL DEFAULT '0' COMMENT '是否删除(1.已删除0.未删除)',
 */
async function Match_list() {

    json = await getJsonRzt('Basketball.Live.Match_list')


    for (item of json.data.matches) {
        try {
            matchid = item[0];
            比赛总节数 = item[1];
            赛事id = item[2];
            比赛状态 = item[3];
            比赛时间 = item[4];
            当前总秒钟数 = item[5];
            // 1512,//赛事id
            // 8,//比赛状态
            // 1516638035,//比赛时间
            // 91,//当前总秒钟数，显示转换成 mm:ss


            类型 = item[9][0];
            阶段id = item[9][1];
            赛季id = item[9][2];
            // 1,//类型 1-常规赛 2-季后赛 3-季前赛 4-全明星 5-杯赛
            // 0,//阶段id
            // 1041//赛季id


            logger.info(item);

            //unique
            uniqueIdx("basketball_matche_t", "id", matchid);

            sql = 'insert  into basketball_matche_t('
                + " id,match_event_id,total_sections,    match_status,match_time,current_total_seconds,   season_id,match_detail,animation, intelligence ,compatible  )    values( "
                + "@id@,@赛事id@,@比赛总节数@,   @比赛状态@,@比赛时间@,@当前总秒钟数@,   @赛季id@,'0','0','0','3' )";


            sql = sql.replace('@id@', "'" + matchid + "'")

            sql = sql.replace('@赛事id@', "'" + 赛事id + "'")

            sql = sql.replace('@比赛总节数@', "'" + 比赛总节数 + "'")

            sql = sql.replace('@比赛时间@', "'" + 比赛时间 + "'")

            sql = sql.replace('@当前总秒钟数@', "'" + 当前总秒钟数 + "'")

            sql = sql.replace('@赛季id@', "'" + 赛季id + "'")

            sql = sql.replace('@比赛状态@', "'" + 比赛状态 + "'")

            // sql = sql.replace('@name_en@', "'" + item.name_en + "'")

            // sql = sql.replace('@short_name_en@', "'" + item.short_name_en + "'")

            // sql = sql.replace('@logo@', "'" + item.logo + "'")


            logger.info(sql);
            var rzt = await query(connection, sql)
            logger.info(rzt);

        } catch (e) {
            logger.error(e);

        }

        //    break;
        //   process.exit();
    }



    console.log("f");
}


async function areas_list() {

    //areas




    json = await getJsonRzt('Basketball.Basic.Matchevent_list')
    // url = "http://www.skrsport.live/?service=Basketball.Basic.Match_deleted_ids&username=sport_api&secret=0gclkqzK";
    for (var fld in json.data.areas) {
        // for (item of json.data.teams) {

        id = fld;
        item = json.data.areas[fld];

    // for (item of json.data.countrys) {

        try {
            logger.info(item);

            //unique
            uniqueIdx("area_t", "id", item.id);


            sql = 'insert  into area_t(id,name_zh,name_zht,name_en)values( @id@,@name_zh@,@name_zht@,@name_en@)';


            sql = sql.replace('@id@', "'" + item.id + "'")

            sql = sql.replace('@area_id@', "'" + item.area_id + "'")

            sql = sql.replace('@country_id@', "'" + item.country_id + "'")

            sql = sql.replace('@name_zh@', "'" + item.name_zh + "'")

            sql = sql.replace('@short_name_zh@', "'" + item.short_name_zh + "'")

            sql = sql.replace('@name_zht@', "'" + item.name_zht + "'")

            sql = sql.replace('@short_name_zht@', "'" + item.short_name_zht + "'")

            sql = sql.replace('@name_en@', "'" + item.name_en + "'")

            sql = sql.replace('@short_name_en@', "'" + item.short_name_en + "'")

            sql = sql.replace('@logo@', "'" + item.logo + "'")


            logger.info(sql);
            var rzt = await query(connection, sql)
            logger.info(rzt);

        } catch (e) {
            logger.error(e);

        }

        // break;
        // process.exit();
    }

    //   basket_match_event_t

    console.log("f");
}



async function countrys_list() {

    //countrys




    json = await getJsonRzt('Basketball.Basic.Matchevent_list')
    // url = "http://www.skrsport.live/?service=Basketball.Basic.Match_deleted_ids&username=sport_api&secret=0gclkqzK";
    for (var fld in json.data.countrys) {
        // for (item of json.data.teams) {

        id = fld;
        item = json.data.countrys[fld];

    // for (item of json.data.countrys) {

        try {
            logger.info(item);

            //unique
            uniqueIdx("country_t", "id", item.id);


            sql = 'insert  into country_t(id,name_zh,name_zht,name_en)values( @id@,@name_zh@,@name_zht@,@name_en@)';


            sql = sql.replace('@id@', "'" + item.id + "'")

            sql = sql.replace('@area_id@', "'" + item.area_id + "'")

            sql = sql.replace('@country_id@', "'" + item.country_id + "'")

            sql = sql.replace('@name_zh@', "'" + item.name_zh + "'")

            sql = sql.replace('@short_name_zh@', "'" + item.short_name_zh + "'")

            sql = sql.replace('@name_zht@', "'" + item.name_zht + "'")

            sql = sql.replace('@short_name_zht@', "'" + item.short_name_zht + "'")

            sql = sql.replace('@name_en@', "'" + item.name_en + "'")

            sql = sql.replace('@short_name_en@', "'" + item.short_name_en + "'")

            sql = sql.replace('@logo@', "'" + item.logo + "'")


            logger.info(sql);
            var rzt = await query(connection, sql)
            logger.info(rzt);

        } catch (e) {
            logger.error(e);

        }

        // break;
        // process.exit();
    }

    //   basket_match_event_t

    console.log("f");
}


async function Matchevent_list() {

    json = await getJsonRzt('Basketball.Basic.Matchevent_list')
    // url = "http://www.skrsport.live/?service=Basketball.Basic.Match_deleted_ids&username=sport_api&secret=0gclkqzK";

    for (item of json.data.matchevents) {

        try {
            logger.info(item);

            //unique
            sql = 'select * from basket_match_event_t where id=' + item.id
            var rzt = await query(connection, sql)
            if (rzt.length > 0)
                continue;
            sql = 'insert  into basket_match_event_t(id,area_id,country_id,name_zh,short_name_zh,name_zht,short_name_zht,name_en,short_name_en,match_logo)values( @id@,@area_id@,@country_id@,@name_zh@,@short_name_zh@,@name_zht@,@short_name_zht@,@name_en@,@short_name_en@,@logo@)';


            sql = sql.replace('@id@', "'" + item.id + "'")

            sql = sql.replace('@area_id@', "'" + item.area_id + "'")

            sql = sql.replace('@country_id@', "'" + item.country_id + "'")

            sql = sql.replace('@name_zh@', "'" + item.name_zh + "'")

            sql = sql.replace('@short_name_zh@', "'" + item.short_name_zh + "'")

            sql = sql.replace('@name_zht@', "'" + item.name_zht + "'")

            sql = sql.replace('@short_name_zht@', "'" + item.short_name_zht + "'")

            sql = sql.replace('@name_en@', "'" + item.name_en + "'")

            sql = sql.replace('@short_name_en@', "'" + item.short_name_en + "'")

            sql = sql.replace('@logo@', "'" + item.logo + "'")


            logger.info(sql);
            var rzt = await query(connection, sql)
            logger.info(rzt);

        } catch (e) {
            logger.error(e);

        }

        //    break;
        //   process.exit();
    }

    //   basket_match_event_t

    console.log("f");
}
async function uniqueIdx(tab, col, val) {


    var sql = "select * from " + tab + " where " + col + "='" + val + "'";
    var rzt = await query(connection, sql)
    if (rzt.length > 0) {
        ex = {};
        ex.sql = sql
        ex.name = 'uniqueEx';

        throw JSON.stringify(ex);
    }

}

async function getJsonRzt(svr) {



    var fs = require("fs");
    fname = "d:\\spddata\\" + svr + "_rzt.json";
    if (fs.existsSync(fname)) {
        logger.info("file exist " + fname);
        return JSON.parse(fs.readFileSync(fname))

    } else {
        url = "http://www.skrsport.live/?service=" + svr + "&username=sport_api&secret=0gclkqzK";


       
        const request = require("request");
        const util = require('util')
        const requestPromise = util.promisify(request);
        const response = await requestPromise(url);
        console.log('response', response.body);
        fs.writeFileSync(fname, response.body);
        return response;
    }



}