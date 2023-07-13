const args = process.argv.slice(2)
//var param=args[0];
var param = (new Buffer(args[0], 'base64').toString())
//var param={};

var fs = require('fs');

var cfgObj = JSON.parse(fs.readFileSync('a_cfg.json') + '');
console.log(cfgObj)
var $url = cfgObj['url'];


//"https://7398c09d63b0.ngrok.io/v1/api/order/build";
console.log($url);
console.log(param);
var prmObj = JSON.parse(param);
const axios = require('axios')

//zwajye cyifen json hesh txt...zosh yaosi obj shg json ,zo  head add app/json,,beir  txt ..
axios
    .post($url, prmObj)
    .then(res => {
        //  console.log(`statusCode: ${res.statusCode}`)   //statusCode: undefined
        console.log(res.data);
        //   console.log(res)
    })
    .catch(error => {
        console.error(error)
    })