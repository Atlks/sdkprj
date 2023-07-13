let set = new Set(); //或者 new Set(null);

  //require('firefoxdriver');  
  require('geckodriver');  //for ff

  var { Builder, By, Key, until } = require('selenium-webdriver');
  var webdriver = require('selenium-webdriver'); //导入selenium 库
  //var driver = new webdriver.Builder().forBrowser('firefox').build(); //创建一个chrome 浏览器实例
  var driver=null;




(async function example() {

  if(driver==null)
  driver  = await new Builder().forBrowser('firefox').build();   //chrome   firefox
  logmdx = require('./jsdk/log.js');
  logger = logmdx.logger;
  logger.info("this is a info msg");


  //'https://cn.pornhub.com/video?c='+j+'&page='+i;


  for (i = 1; i <= 200; i++) {
    cateid = i;
    url = 'https://cn.pornhub.com/video?c=' + cateid + '&page=2';
    await getDetailWbdr(url, cateid, 2);
  }


  setInterval(function () {

    console.log(JSON.stringify(set))

    logger.info(JSON.stringify(set));

  }, 5000)
})();

async function getDetailWbdr(url, cateid, page) {


  fname = "D:\\prj\\dataCateTest\\hornhub" + "_cate" + cateid + "_page" + page + '.html';
  console.log(fname);
  logger.info(fname);

  var fs = require("fs");
  if (fs.existsSync(fname)) {
      logger.info("getDetailWbdr::file exist,return  " + fname);
      return;
  }

  await driver.get(url)
  title=await driver.title();
if( title='没发现页面')
{
  return;
}
  getPageSource1 = await driver.getPageSource()
  // driver.getPageSource().then(function (getPageSource) {
  set.add(cateid);

  // console.log(getPageSource);


  //function save_rzt() {

  var fs = require("fs");

  console.log("准备写入文件");
  //console.log(body);

  fname = "D:\\prj\\dataCateTest\\hornhub" + "_cate" + cateid + "_page" + page + '.html';
  console.log(fname);
  logger.info(fname);

  var fs = require("fs");
  if (fs.existsSync(fname)) {
      logger.info("file exist " + fname);
      return;
  }


  fs.writeFileSync(fname, getPageSource1);

  // });

  logger.info("this is a info msg" + url);

  //console.log   "user-agent","Mozilla/5.0"


}


// function getDetail(url, cateid, page) {
//   logger.info("this is a info msg" + url);
//   const request = require('request');
//   //console.log   "user-agent","Mozilla/5.0"
//   request(url, { headers: { 'User-Agent': "Mozilla/5.0" } }, (err, res, body) => {
//     if (err) { return console.log(err); }

//     set.add(cateid);
//     console.log(res);
//     //  console.log(body);




//     const cheerio = require('cheerio')
//     const $ = cheerio.load(body)
//     var a_arr = $('li a[class=""]').toArray();
//     console.log(a_arr)
//     //$('li').toArray()


//   });

// }

// function save_rzt() {

//   var fs = require("fs");

//   console.log("准备写入文件");
//   //console.log(body);

//   fname = "D:\\prj\\data\\hornhub" + "_cate" + cateid + "_page" + page + '.html';
//   console.log(fname);
//   fs.writeFileSync(fname, body);
// }
