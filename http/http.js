function timeA() { console.log('Function timeA in a.js.') }

//    npm i node-fetch@2.6     must 2.x   use es5 impt mode require('packageName');   if 3.0x use import {  } from "module";
module.exports = {
    timeA,
    ff() { console.log('Function fff in b.js.') },
    ff2() { console.log('Function fff in b.js.') },
    B_A() { console.log('Function B_A in b.js.') },
    async http_get239(url) {
        console.log(url);
        const fetch = require('node-fetch');

        //  import fetch from "node-fetch"; //es6 mode
        const res = await fetch(url);
        const headerDate = res.headers && res.headers.get('date') ? res.headers.get('date') : 'no response date';
        console.log('___Status Code:', res.status);
        console.log('___+Date in Response header:', headerDate);

        const r = await res.text();
        // await res.json();    require('node-fetch')(url).text()
        return r;

    }
}