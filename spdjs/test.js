const Youdao = require('youdao-fanyi');
 
const fanyi = Youdao({
  appkey: '-- Here is your appkey --',
  secret: '-- Here is your secret --',
});
 
fanyi('hello world', (err, res) => {
  if(err) return console.error(err);
  console.log(res);
    
});




// const translate = require('translate-api');

// //  let transUrl = 'https://nodejs.org/en/';
// //  translate.getPage(transUrl).then(function(htmlStr){
// //    console.log(htmlStr.length)
// //  });

// let transText = 'hello world!';
// translate.getText(transText, { to: 'zh-CN' }).then(function (text) {
//   console.log(text)
// });



function xx() {
  // Imports the Google Cloud client library
  const { Translate } = require('@google-cloud/translate').v2;

  // Creates a client
  const translate = new Translate();

  /**
   * TODO(developer): Uncomment the following lines before running the sample.
   */
  const text = 'The text to translate, e.g. Hello, world!';
  const target = 'zh';

  async function translateText() {
    // Translates the text into the target language. "text" can be a string for
    // translating a single piece of text, or an array of strings for translating
    // multiple texts.
    let [translations] = await translate.translate(text, target);
    translations = Array.isArray(translations) ? translations : [translations];
    console.log('Translations:');
    translations.forEach((translation, i) => {
      console.log(`${text[i]} => (${target}) ${translation}`);
    });
  }

  //translateText();

}



// const translate = require('google-translate-api');

// // (async () => {

//   const util = require('util')
// const requestPromise = util.promisify(translate);
// // const txt = 'Sometimes, the API will not use the auto corrected text in the translation:!';

// // //ZH-CN
// //   const res = await requestPromise(txt, { from: 'en', to: 'ZH-CN' });

// //   console.log(res.text);
// // })();




// translate('Sometimes, the API will not use the auto corrected text in the translation:!', { from: 'en', to: 'nl' }).then(res => {
//   console.log(res.text);
//   //=> Ik spreek Nederlands!
//   console.log(res.from.text.autoCorrected);
//   //=> true
//   console.log(res.from.text.value);
//   //=> I [speak] Dutch!
//   console.log(res.from.text.didYouMean);
//   //=> false
// }).catch(err => {
//   console.error(err);
// });



// xthrow 0

// // main
// logmdx = require('./jsdk/log.js');
// logger = logmdx.logger;
// var fs = require("fs");


// for (j = 1; j <= 200; j++)
//   for (i = 1; i <= 2; i++) {
//     // url = 'https://cn.pornhub.com/video?c=80&page=' + i;
//     // cateid = 24; 
//     cateid = j; cate = '';
//     //cate='公众野战';
//     page = i;
//     fname = "D:\\prj\\dataCateTest\\hornhub" + "_cate" + cateid + "_page" + page + '.html';
//     console.log(fname);
//     logger.info(fname)

//     if (fname.indexOf('.nopage') > 0)
//       continue;
//     try {
//       var html = fs.readFileSync(fname, "utf8");
//       if (html.indexOf('没发现页面') > 0)
//         fs.renameSync(fname, fname + '.nopage')

//     } catch (e) {
//       console.log(e)
//       logger.error(e)
//     }

//   }







// var date1 = '2020/02/25 18:23:00';  //开始时间
// var now = new Date();    //结束时间
// var date3 = now.getTime() - new Date(date1).getTime();   //时间差的毫秒数    
// //计算出相差天数
// var min = Math.floor(date3 / (1000 * 60))
// console.log(min)

// console.log(parseInt("1"))

// s = '/view_video.php?viewkey=ph5cbc7af265355';
// index = s.indexOf('viewkey=');
// pageid = s.substring(index + 8);
// console.log(pageid)




// jsonstr = '[{"urlid":"/view_video.php?viewkey=1008110901"},{"urlid":"/view_video.php?viewkey=1027011661"},{"urlid":"/view_video.php?viewkey=1031923747"},{"urlid":"/view_video.php?viewkey=1032854684"},{"urlid":"/view_video.php?viewkey=1038116855"}]'
// jsonarr = JSON.parse(jsonstr)
// for (it of jsonarr) {
//   url = 'https://cn.pornhub.com' + it.urlid
//   console.log(url)
// }