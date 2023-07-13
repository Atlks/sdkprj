keyword='';
async function feilonveo2rss(url3,keyword7) {
    keyword=keyword7;
   // throw 66;

    const util = require('util')
    const request = require("request");

    const requestPromise = util.promisify(request);
    const response = await requestPromise(url3);
    // console.log('response', response.body);
    var fs = require("fs");
    try{
        fs.writeFileSync("d:\\flw.htm", response.body);
    }
  catch(e){}


    //-----------------rss




    //rss

   


    html = response.body

    const cheerio = require('cheerio')
    $ = 8
    //  html='<a href="thread xxxx">aaatttt</a>';
    $ = cheerio.load(html)
  title=  $('title').text()
  desc=$('meta[name="description"]').attr('content');
    
    var elms = [];

    await  $('a').each(await async function (index, element) {
        elms.push(element);

    });



     // Require module
     var Feed = require('feed').Feed;

     // Initializing feed object
     var feed = new Feed({
         title: title,
         description:desc,
         link: 'http://example.com/',
         image: 'http://example.com/logo.png',
         copyright: 'Copyright © 2013 John Doe. All rights reserved',
 
         author: {
             name: 'John Doe',
             email: 'john.doe@example.com',
             link: 'https://example.com/john-doe'
         }
     });
    
    for (e of elms) {

        try {

            await li_each_event(0, e,feed)
        } catch (e) {
            console.error('error: ' + JSON.stringify(e));
            console.error(e)
        }

    }


 

    var output = feed.rss2();
    //output = feed.atom1();
    console.log(output)
    //  var a_arr = $('a').toArray();



    return output;
}

async function li_each_event(index, element,feed) {
    title = $(element).text().trim();
    href = $(element).attr('href');
    
    if (href.indexOf(keyword) >= 0) {
        if ($(element).text().trim().length > 0) {
            console.log($(element).text())
            if (href.indexOf("http") != 0)
                herf = ('https://www.flw.ph/' + href)

            feed.addItem({
                title: title,
                link: herf,
                guid: 'http://attilax.com/aa?rdm='+Math.random() ,
                description: title,
                date: new Date()
            });
        }
    }
}
function getLogger() {


    // 基本使用

    var log4js = require('log4js');

    var logger = log4js.getLogger();

    logger.level = 'debug';

    logger.debug("Some debug messages");

    // 第二种配置方式

    log4js.configure({

        appenders: {

            ruleConsole: { type: 'console' },

            ruleFile: {

                type: 'dateFile',

                filename: 'logs/jslog_server-',

                pattern: 'yyyy-MM-dd.log',

                maxLogSize: 10 * 1000 * 1000,

                numBackups: 3,

                alwaysIncludePattern: true

            }

        },

        categories: {

            default: { appenders: ['ruleConsole', 'ruleFile'], level: 'info' }

        }

    });



    return logger;
}
//async function feilonveo2rss() {

exports.feilonveo2rss = feilonveo2rss;