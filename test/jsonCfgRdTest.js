var fs = require('fs');

// file is included here:
var cfgObj = JSON.parse(fs.readFileSync('a_cfg.json') + '');
console.log(cfgObj)
var $url = cfgObj['url'];
console.log($url);