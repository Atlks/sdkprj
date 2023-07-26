// nodejs sqlite bpx 最佳实践
const sqlite3 = require("sqlite3");
const util = require("util");
var mod1 = require("./atisdk/sqltUtil");

const dbfile = "user_19255691_dbf.db";
db = new sqlite3.Database(dbfile);
db.run = util.promisify(db.run);
db.all = util.promisify(db.all);

(async () => {
  //---------create table

  await mod1.run("create table  userinfo(c JSON)", dbfile);
 

  // --------- insert dt
  o = { dt: 2022, evt: "meet ", time: new Date().toLocaleTimeString() };
  sql = " insert into userinfo values('" + JSON.stringify(o) + "') ";
  await db.run(sql);
  console.log("   >>>>"+sql);

  //----search query
  sql = "SELECT json_extract(c,'$.time') as c1 FROM userinfo;";
  console.log(sql);
  rows = await db.all(sql);
  console.log(rows);
})();
