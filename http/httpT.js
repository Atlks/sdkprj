const { ff } = require('./http.js');

//var { ff2 } = require('./http.js');
// ff2 = require('./http.js'); err

var { ff2 } = require('./http.js');

ff();
ff2();

var { timeA } = require('./http.js');
timeA();

var { http_get } = require('./http.js');






(async() => {
    timex = Math.floor(Date.now() / 1000); //  Date.now();

    $url = `https://api.etherscan.io/api?module=block&action=getblocknobytime&timestamp=${timex}&closest=before&apikey=VASRGU6XT768WSKI2VME6Z8ZK3GK5E3UDT`;
    var txt = await http_get($url)
    console.log(txt)

})().catch(e => {
    // Deal with the fact the chain failed
});