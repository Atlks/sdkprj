//需要注意的是 await 只能在 async function 内使用，所以常常有


(async () => {

//   testawait requste\
logmdx = require('./jsdk/log.js');
logger = logmdx.logger;
console.log("--")
cateid=25
for (i = 1; i <= 50; i++) {
    page = i;
 
    url = 'https://cn.pornhub.com/video?c=' + cateid + '&page='+page;
     
    body=    await getDetail(url, cateid, 4);
    console.log(body)
  

}



})();







function getDetail(url, cateid, page) {
    logger.info("this is a info msg" + url);
    const request = require('request');
    //console.log   "user-agent","Mozilla/5.0"
    return new Promise(function (resolve, reject) {
        request(url, { headers: { 'User-Agent': "Mozilla/5.0" } }, (error, res, body) => {
            if (error) {
                reject(error);
            } else {
                resolve(body);
            }
        });
    });




}