



function driverSync(driver,url,invokeFun)
{
    (async () => {

        let result = await getPromise(url , {'auth' : {
            'user' : 'xx',
            'pass' : 'xx',
            'sendImmediately' : 'false',
        }});
        // 可以加入 try catch 捕获异常  也可以加 .catch()
        console.log("result" , result);
        console.log(result.body)
      
      
      })();
}



function driverSync_core(driver,url,invokeFun) {
    // const request = await require('request');
    //console.log   "user-agent","Mozilla/5.0"
    return new Promise(function (resolve, reject) {
  
  
  
  
      driver.get(url)
  
    //   driver.sleep(10 * 1000).then(function () { //等待20秒
    //     try {
  
  
  
    //       //  console.log(driver.getCurrentUrl());
  
    //       driver.getTitle().then(function (title) {
    //         console.log(title);
    //       });
  
  
    //       driver.getPageSource().then(function (getPageSource) {
  
  
    //         //  console.log(getPageSource);
  
    //         resolve(getPageSource);
  
    //       });
  
    //     } catch (e) {
    //       reject(e);
    //     }
  
    //     // driver.quit(); //关闭浏览器
    //   });
  
  
  
  
    });//  promiss end
  }