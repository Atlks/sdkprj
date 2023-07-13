//c: \w\ jbbot > C: \phpstudy_pro\ Extensions\ php\ php7 .3 .4 nts\ php.exe think swoole //ink swoole//// 
//   https://api.telegram.org/bot5464498785:AAGtLv-M-RKgRoIh5G3XEfkdqkCPiVBB1NA/getUpdates
////////   npm install node-telegram-bot-api


const TelegramBot = require('node-telegram-bot-api');

// replace the value below with the Telegram token you receive from @BotFather
const token = '5464498785:AAGtLv-M-RKgRoIh5G3XEfkdqkCPiVBB1NA';

// Create a bot that uses 'polling' to fetch new updates
const bot = new TelegramBot(token, { polling: true });



// Listen for any kind of message. There are different kinds of
// messages.
bot.on('message', (msg) => {
    const chatId = msg.chat.id;

    $msgx = msg.text;

    /*
     if ($msx == "余额") {、、
        // 用户ID: 879006550 用户名: 十 jarkas 刘洋 汤姆 余额: 0 输赢: 0,
    }
     */


    // send a message to the chat acknowledging receipt of their message
    bot.sendMessage(chatId, 'Received your message');
    console.log(msg);


    var fs = require("fs");
    $fname = Math.random();
    fs.writeFileSync($fname + ".json", JSON.stringify(msg));

    const { exec } = require('child_process');
    var execSync = require('child_process').execSync;


    $cmd = "C:\\phpstudy_pro\\Extensions\\php\\php7.4.3nts\\php.exe  C:\\w\\jbbot\\tlgrmHdl.php " + $fname;
    console.log($cmd);

    execSync($cmd);
    console.log(999)
});