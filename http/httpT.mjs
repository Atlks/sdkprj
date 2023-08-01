import { ff } from './http.js';



ff();



//import { http_get239 } from './http.js'; //err


import pkg from './http.js';
const { http_get239 } = pkg; //or  pkg.http_get239()

/**
 * 
 * import pkg from './cjs/a.js';  // 以 default export 的形式引入

pkg.foo();  // 正常执行
 */

//var { http_get } = http_getM.http_get;




var timex = Math.floor(Date.now() / 1000); //  Date.now();

var $url = `https://api.etherscan.io/api?module=block&action=getblocknobytime&timestamp=${timex}&closest=before&apikey=VASRGU6XT768WSKI2VME6Z8ZK3GK5E3UDT`;
var txt = await http_get239($url);


console.log(await
    import ('node-fetch')($url).text());
//console.log(txt)