
//return;
// log4js = require('log4js');
logmdx = require('./jsdk/log.js');
logger = logmdx.logger;
console.log("--");
var fs = require("fs");



//rss
//import { Feed } from "feed";
const Feed = require('feed').Feed;
//const Feed  = require('feed')
let feed = new Feed({
    title: 'Generate RSS feed wtih NodeJS',
    description: 'Generate RSS feed wtih NodeJS',
    author: {
      name: 'Programmer blog',
      link: 'http://programmerblog.net/'
    }
  });

//   feed.addItem({
//     title:'title',
//     link:"http://localhost/news/",
//     description: 'description',
//     author: [{
//       name: 'Programmer Blog',
//       email: 'janedoe@example.com',
//       link: 'http://programmerblog.net'
//     }],
//     date: new Date(),
//   });
//   var rssdoc = feed.rss2();
//   console.log(rssdoc)

//throw 55


(async () => {

    // Match_list()
    //  team_list()
    //  Match_list()
    //  countrys_list();
    //  areas_list();
    try {
        await feilonveo2rss()
    } catch (e) {
        console.log(e)
    }


})();
const cheerio = require('cheerio')
$ = 8
async function feilonveo2rss() {

    url = 'https://www.flw.ph/forum-40-1.html'
    const util = require('util')
    const request = require("request");

    const requestPromise = util.promisify(request);
    const response = await requestPromise(url);
    // console.log('response', response.body);
    fs.writeFileSync("d:\\flw.htm", response.body);


    //-----------------rss
    // Require module
    var Feed = require('feed').Feed;

    // Initializing feed object
    var feed = new Feed({
        title: 'My Feed Title',
        description: 'This is my personnal feed!',
        link: 'http://example.com/',
        image: 'http://example.com/logo.png',
        copyright: 'Copyright © 2013 John Doe. All rights reserved',

        author: {
            name: 'John Doe',
            email: 'john.doe@example.com',
            link: 'https://example.com/john-doe'
        }
    });


    html = response.body
    //  html='<a href="thread xxxx">aaatttt</a>';
    $ = cheerio.load(html)

    $('a').each(function (index, element) {
        // elms.push(element);
        try {
            title = $(element).text().trim();
            href = $(element).attr('href');
            if (href.indexOf('thread') >= 0) {
                if ($(element).text().trim().length > 0) {
                    console.log($(element).text())
                    if (href.indexOf("http") != 0)
                        herf = ('https://www.flw.ph/' + href)

                    feed.addItem({
                        title: title,
                        link: herf,
                        description: title,
                        date: new Date()
                    });
                }
            }
        } catch (e) {
            logger.error(e)
        }


        //  element.attr('text')

    });

    var output = feed.rss2();
    console.log(output)
    //  var a_arr = $('a').toArray();

 

    return response;
}
