
console.log("ss")
//reqsysn
url='https://cn.pornhub.com/view_video.php?viewkey=ph5d2b7ae80c250'

require('chromedriver'); 
const {Builder, By, Key, until} = require('selenium-webdriver');
let driver = await new Builder().forBrowser('chrome').build();   //chrome   firefox
(async function example() {
  let driver = await new Builder().forBrowser('chrome').build();   //chrome   firefox
  try {
    await driver.get(url);
 //   await driver.findElement(By.name('q')).sendKeys('webdriver', Key.RETURN);
  //  await driver.wait(until.titleIs('webdriver - Google Search'), 1000);
    getPageSource1=   await   driver.getPageSource();
    console.log(getPageSource1);
  } finally {
  //  await driver.quit();
  }
})();

console.log("F")
// process.exit();

// url='https://cn.pornhub.com/view_video.php?viewkey=ph5d2b7ae80c250'

// const request = require('request');
// const util = require('util');
// //var url = "https://www.baidu.com/";
// const getPromise = util.promisify(request.get);



// (async () => {

//     let result = await getPromise(url , {'auth' : {
//         'user' : 'xx',
//         'pass' : 'xx',
//         'sendImmediately' : 'false',
//     }});
//     // 可以加入 try catch 捕获异常  也可以加 .catch()
//     console.log("result" , result);
//     console.log(result.body)
  
  
//   })();


