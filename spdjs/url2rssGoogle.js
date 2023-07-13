(async () => {

    mod = require('./flwUrl2rss.js');
    rzt = await mod.feilonveo2rss('https://www.flw.ph/forum-40-1.html', 'thread');
    console.log(rzt);

})();

//return;
// //throw 5;


// (async () => {




// })();


var http = require('http');

// create a server object:
http.createServer(function (req, res) {
    // logger = getLogger();
    (async () => {

        var url = require('url');
        if (req.url == '/flw') {

            mod = require('./flwUrl2rss.js');
            message = await mod.feilonveo2rss('https://www.flw.ph/forum-40-1.html', 'thread');
            //   res.status(200).send(message);
            res.write(message); //write a response to the client
            res.end();
        }

    })();

}).listen(8888); //the server object listens on port 8080

console.log("f");
