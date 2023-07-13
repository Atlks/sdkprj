mdx = require('./conn.js');
connection = mdx.conn;
//detailDbInsert


logmdx = require('./jsdk/log.js');
logger = logmdx.logger;
logger.info("this is a info msg");
//  -["C:\\Program Files\\nodejs\\node.exe","d:\\prj\\spdJs\\detailDbInsert.js","testparam"]



var options = process.argv;
param = options[2];
console.log("------------------------" + JSON.stringify(options))
logger.info("------------------------" + JSON.stringify(options));
logger.info("------------------true parem-" + param);

unescapeParam = unescape(param)
logger.info("------------------unescapeParam-" + unescapeParam);
obj2str = options[0];
console.log("--subprocess param:" + JSON.stringify(options))
sql = "INSERT INTO 抓取数据记录(数据,urlid) VALUES(?,'@urlid@')";
json = JSON.parse(unescapeParam)

sql = sql.replace('@urlid@', '"' + json.LiAattribs.href + '"')
logger.info(sql);
connection.query(sql, [unescapeParam], (err, results) => {
  if (err) {
   // console.log(err);
   logger.error("query err:"+ sql);
    logger.error(err);
  }
  logger.info(results);
  process.exit();
})
