//c: \w\ jbbot > C: \phpstudy_pro\ Extensions\ php\ php7 .3 .4 nts\ php.exe think swoole //ink swoole//// 
//   https://api.telegram.org/bot5464498785:AAGtLv-M-RKgRoIh5G3XEfkdqkCPiVBB1NA/getUpdates
////////   npm install node-telegram-bot-api

$phpexe = "C:\\phpstudy_pro\\Extensions\\php\\php7.4.3nts\\php.exe";
$tlghr_msg_hdl = " C:\\w\\jbbot\\tlgrmHdl.php ";
const token = '5464498785:AAGtLv-M-RKgRoIh5G3XEfkdqkCPiVBB1NA';



bot = getTelegramBot(token);


bot.on('message', (msg) => {

    //   $msgx = msg.text;
    console.log(msg);
    bot.sendMessage(msg.chat.id, 'Received your message');


    $fname = Math.random();
    writeFileSyncx($fname, JSON.stringify(msg));
    execSyncx($phpexe + " " + $tlghr_msg_hdl + " " + $fname);
    console.log(999)
});































function getTelegramBot(token) {
    const TelegramBot = require('node-telegram-bot-api');

    // replace the value below with the Telegram token you receive from @BotFather


    // Create a bot that uses 'polling' to fetch new updates
    const bot = new TelegramBot(token, { polling: true });

    return bot;
}



function writeFileSyncx(fil, str) {
    var fs = require("fs");
    fs.writeFileSync($fname + ".json", str);
}



function execSyncx(cmd) {

    console.log(cmd);
    const { exec } = require('child_process');
    var execSync = require('child_process').execSync;
    execSync(cmd)
}