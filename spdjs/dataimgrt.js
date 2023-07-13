
function getkey() { }
(async () => {
    logmdx = require('./jsdk/log.js');
    logger = logmdx.logger;
    logger.info("this is a info msg");
    mdx = require('./conn.js');
    connection = mdx.conn;

    query = require('./jsdk/mysql.js')

    const readline = require('readline');
    const fs = require('fs');


    while (true) {

        sql = "select * from      抓取数据记录 where   issynced( 其他扩展字段, '$.synced' )='n' and urlid is not null order by id desc  limit   9"
        logger.info(sql);
        let rows = await query(connection, sql)
        logger.info(rows);
        if (!rows) break;
            if(rows.length==0)
            break;

        lists = JSON.stringify(rows);
        for (row of rows) {
            logger.info(row);
            sql = " update 抓取数据记录 set 其他扩展字段 = json_set(其他扩展字段,'$.synced','y','$.syncedtime',NOW()) where urlid='@urlid@' and id=" + row.id;
            sql = sql.replace('@urlid@', row.urlid)
            logger.info(sql);
            let rzt = await query(connection, sql)
            logger.info(rzt);


            //gene insert 
            // CREATE TABLE `movie_t` (
            //     `id` bigint(32) NOT NULL COMMENT '电影id',
            //     `movie_name` varchar(500) CHARACTER SET utf8 DEFAULT NULL COMMENT '电影名称',
            //     `show_year` date DEFAULT NULL COMMENT '电影年份',
            //     `nation` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '国家',
            //     `director` varchar(1000) CHARACTER SET utf8 DEFAULT NULL COMMENT '导演',
            //     `leadactors` varchar(1000) CHARACTER SET utf8 DEFAULT NULL COMMENT '主演',
            //     `screen_writer` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT '屏幕字幕',
            //     `picture` varchar(500) CHARACTER SET utf8 DEFAULT NULL COMMENT '封面',
            //     `averating` double(11,1) DEFAULT NULL COMMENT '电影总评分',
            //     `numrating` int(11) DEFAULT NULL COMMENT '热度',
            //     `description` varchar(1000) DEFAULT NULL COMMENT '剧情简介',
            //     `app_picture` varchar(255) DEFAULT NULL COMMENT '移动端背景图片',
            //     `create_time` datetime DEFAULT NULL COMMENT '创建时间',
            //     `source_id` bigint(10) DEFAULT NULL COMMENT '电影原ID',
            //     `source_site_code` varchar(50) DEFAULT NULL COMMENT '原电影站点编号',
            //     `cache_path` varchar(200) DEFAULT NULL COMMENT '视频缓存路径',
            //     PRIMARY KEY (`id`),
            //     KEY `movieIndex` (`movie_name`,`show_year`,`nation`) USING BTREE
            //   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='电影主表';

            try {

                sql_istMv = "insert movie_t(id,movie_name,description,create_time,source_site_code,cache_path)values('@id@',    '@t@'  ,'@desc@' ,now(),'pornhub',  '@url@'   );"


                sql_istMv = sql_istMv.replace('@id@', new Date().getTime());
                sql_istMv = sql_istMv.replace('@desc@', row.数据);
                json = JSON.parse(row.数据)
                try { sql_istMv = sql_istMv.replace('@t@', json.LiAattribs.title) } catch (e) { }
                try { sql_istMv = sql_istMv.replace('@url@', json.LiAattribs.href) } catch (e) { }

                //  sql_istMv = sql_istMv.replace('@urlid@', row.urlid)
                logger.info(sql_istMv);
                //   throw 'die'
                let rzt9 = await query(connection, sql_istMv)
                logger.info(rzt9);
            } catch (e2) {
                logger.error(e2);
            }
        }


    }





    // main().catch(error => console.log(error));


})();