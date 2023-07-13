//  npm install  axios
// 安装依赖：npm install body-parser express --save-dev
var express = require('express');
var app = express();
var fs = require("fs");
var bodyParser = require('body-parser');//解析,用req.body获取post参数
app.get('/a1', function (req, res) {
    res.end("halo");
});

//paresr  can use mlt in same time,auto invoke where client is send..thend set in req.body..
// parse application/json
app.use(bodyParser.json());
app.use(bodyParser.raw());

// auto invoke by parse where client is   'Content-Type: text/plain; charset=utf-8',
app.use(bodyParser.text());
// parse application/x-www-form-urlencoded
app.use(bodyParser.urlencoded({extended: false}));
app.post("/pst", function (req, res) {
    console.log(JSON.stringify(req.body));
    res.end("ok..");
})


app.post("/pstxt", function (req, res) {
    console.log((req.body));
    res.end("pstxt ok..");
})

var server = app.listen(888, function () {
    var host = server.address().address
    var port = server.address().port
    console.log("Example app listening at http://%s:%s", host, port)
});

//  npm install express   ...open ide termnal view
//http://localhost:888/a1
//http://localhost:888/pst