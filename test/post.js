//npm i axios
const axios = require('axios')


const fs = require("fs")
let rs = fs.readFileSync('C:/modyfing/jbbot/test/wbhkPstData.json', "utf8");

//console.log(rs)
jsonObj = JSON.parse(rs)
axios
    .post('http://localhost/keywordHander.php', jsonObj)
    .then(res => {
        console.log(`状态码: ${res.statusCode}`)
        console.log(res)
    })
    .catch(error => {
        console.error(error)
    })


//  node  C:\modyfing\jbbot\test\post.js