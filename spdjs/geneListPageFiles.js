
// node   geneListPageFiles.js
// node  D:\prj\spdJs\geneListPageFiles.js 2 0
maindir = 'D:\\prj\\dataCateTest';


(async () => {
   await appMain();
 //  await clusefun();
})();

async function clusefun() {

  var cluster = require('cluster');

  var numCPUs = require('os').cpus().length; // 获取CPU的个数
  console.log("numCPUs:" + numCPUs)
  if (cluster.isMaster) {
    console.log(`main主进程 ${process.pid} 正在运行`);
    for (var i = 0; i < 2; i++) {
      cluster.fork();
    }

    cluster.on('exit', function (worker, code, signal) {
      console.log('worker ' + worker.process.pid + ' died');
    });
  } else {
    // sub process
    //appMain()
    console.log(`工作进程 ${process.pid} start  启动`);
    //require("./geneListPageFiles.js");
    await appMain();
    console.log(`工作进程 ${process.pid} 已启动`);

  }
  console.log(`main主进程 ${process.pid} 正在运行 sec`);



}






async function appMain() {


  //require('chromedriver'); //导入chrome浏览器 driver
  //require('firefoxdriver');  
  require('geckodriver');  //for ff

  var { Builder, By, Key, until } = require('selenium-webdriver');


  var webdriver = require('selenium-webdriver'); //导入selenium 库

  var driver = new webdriver.Builder().forBrowser('firefox').build(); //创建一个chrome 浏览器实例



  var threadCount = parseInt(process.argv[2])
  var threaid = parseInt(process.argv[3])
  //paramStartIdex=parseInt(paramStartIdex)
  logmdx = require('./jsdk/log.js');
  logger = logmdx.logger;
  console.log("--");





  var url = 'https://cn.pornhub.com/video?c=80&page=1';

  //  trouble 
  // node.js pachon spider
  // const https = require("https");

  //cateid = 24

  console.log("fi");

  //102,103,10,119,121,129,12,145,
  catids = '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,76,77,78,79,80,81,82,83,84,85,86,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,111,115,121,131,138,139,141,181'
  var arr = catids.split(',')

  // for(j=1;j<200;j++)
  nm = 0;
  var taskNum = 0;
  for (catid of arr) {
    nm++;
    // if(nm<paramStartIdex)
    //   continue  
    for (var i = 500; i <= 700; i++) {

      //task palam lib
      if (threadCount && threadCount > 1)  //multi thread
      {
       // taskNum++;
       taskNum=i;
        var modRzt = taskNum % threadCount;    

        if (modRzt != threaid)
          continue;
      }

      d={"threadCount":threadCount,"threaid:":threaid,"taskNum":taskNum,"modRzt":taskNum % threadCount};
      logger.info( JSON.stringify(d));


      //task palam lib  end 
    

      try {
        page = i
        fname = maindir + "\\hornhub" + "_cate" + catid + "_page" + page + '.html';
        var fs = require("fs");
        if (fs.existsSync(fname)) {
          logger.info("file exist " + fname);
          continue;
        }
        url = 'https://cn.pornhub.com/video?c=' + catid + '&page=' + page;
        logger.info("file not exist,ready to catch ,url: " + url);

        htmlbody = await getDetailV3(url, catid,page, driver);
        if (htmlbody.indexOf('没有发现视频') > 1)
          break;
        writefilex(catid, page, htmlbody)
      } catch (e) {
        logger.error(e);
      }

    }
  }





}



//web driver
async function getDetailV3(url, cateid, page, driver) {
  // const request = await require('request');
  //console.log   "user-agent","Mozilla/5.0"



  await driver.get(url)
  title = await driver.getTitle()
  console.log(title);

  getPageSource1 = driver.getPageSource();

  return getPageSource1



}

//web driver
function getDetailV2(url, cateid, page) {
  // const request = await require('request');
  //console.log   "user-agent","Mozilla/5.0"
  return new Promise(function (resolve, reject) {




    driver.get(url)

    driver.sleep(10 * 1000).then(function () { //等待20秒
      try {



        //  console.log(driver.getCurrentUrl());

        driver.getTitle().then(function (title) {
          console.log(title);
        });


        driver.getPageSource().then(function (getPageSource) {


          //  console.log(getPageSource);

          resolve(getPageSource);

        });

      } catch (e) {
        reject(e);
      }

      // driver.quit(); //关闭浏览器
    });




  });//  promiss end
}

function writefilex(cateid, page, body) {

  var fs = require("fs");

  console.log("准备写入文件");
  //console.log(body);

  fname = maindir + "\\hornhub" + "_cate" + cateid + "_page" + page + '.html';

  var fs = require("fs");
  if (fs.existsSync(fname)) {
    logger.info("file exist " + fname);
    return;
  }

  logger.info("file not exist,ready to gene  " + fname);
  console.log(fname);
  fs.writeFileSync(fname, body);


}


function dep_getDetail(url, cateid, page) {
  const request = require('request');
  //console.log   "user-agent","Mozilla/5.0"
  return new Promise(function (resolve, reject) {
    request(url, { headers: { 'User-Agent': "Mozilla/5.0" } }, (err, res, body) => {
      if (err) {
        // return console.log(err);
        reject(error);
      }
      console.log(res);
      //  console.log(body);


      var fs = require("fs");

      console.log("准备写入文件");
      //console.log(body);

      fname = "D:\\prj\\data\\hornhub" + "_cate" + cateid + "_page" + page + '.html';

      var fs = require("fs");
      if (fs.existsSync(fname)) {
        logger.info("file exist " + fname);
        return;
      }

      logger.info("file not exist,ready to gene  " + fname);
      console.log(fname);
      fs.writeFileSync(fname, body);


      const cheerio = require('cheerio')
      const $ = cheerio.load(body)
      var a_arr = $('li a[class=""]').toArray();
      console.log(a_arr)
      //$('li').toArray()
      resolve(body);

    });

  })
}





// function intervalFunc() {
//       console.log('Cant stop me now!');
//     }

//setInterval(intervalFunc, 1500);
