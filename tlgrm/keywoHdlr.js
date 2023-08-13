//c: \w\ jbbot > C: \phpstudy_pro\ Extensions\ php\ php7 .3 .4 nts\ php.exe think swoole //ink swoole//// 
//   https://api.telegram.org/bot5464498785:AAGtLv-M-RKgRoIh5G3XEfkdqkCPiVBB1NA/getUpdates
////////   npm install node-telegram-bot-api
//   npm install  ini
//   npm install  mysql
// execSync

//   node tlgrm/keywoHdlr.js
const { exec, execSync } = require('child_process');
const TelegramBot = require('node-telegram-bot-api');

ini = require('ini');
var fs = require("fs");
var path = require("path");
const iopath = path.join(__dirname, '../.env'); // 引用Pos.ini的相对地址
const Info = ini.parse(fs.readFileSync(iopath, 'utf-8'));
console.log(Info)

var mysql = require('mysql');
var connection = mysql.createConnection({
    host: Info.database.hostname,
    user: Info.database.username,
    password: Info.database.password,
    database: Info.database.database
});

connection.connect();
//token = "6510408569:AAHrrbsKgCvklwiFje_TKPF-ABMz0kdxn2c" // msg2025
token = "";
connection.query('SELECT  * from setting where id=1  ', function(error, results, fields) {
    if (error) throw error;
    //  console.log(JSON.stringify(results));
    token = results[0].s_value
    console.log('The solution is: ', results[0].s_value);

    invoke_bot(token);
});
connection.end(); //要加不然唱起了回报个 conn close err。。。must add beir longt time
console.log(9999);




function invoke_bot(token) {
    //6357469915: AAGyKxgsBJ4NmaazHG - 6 aiAuoodeT0gJmPA   //ssc2023 bot


    // Create a bot that uses 'polling' to fetch new updates
    const bot = new TelegramBot(token, { polling: true });



    // Listen for any kind of message. There are different kinds of
    // messages.
    bot.on('message', (msg) => {
        chatId = msg.chat.id;
        console.log(msg)
            // send a message to the chat acknowledging receipt of their message
            //  bot.sendMessage(chatId, 'Received your message');

        //  msgx(msg);
        cmd = "node   tlgrm/msgHdl.js " + encodeURI(JSON.stringify(msg));
        $phpexe = "php";
        // $tlghr_msg_hdl = " C:\\w\\jbbot\\tlgrmHdl_temacyo.php ";
        filename = __dirname + "/../think";
        cmd = $phpexe + " " + filename + "    keywdReqHdlr  " + encodeURI(JSON.stringify(msg));
        console.log(cmd)
        exec(cmd)
        console.log(999)
    });
}