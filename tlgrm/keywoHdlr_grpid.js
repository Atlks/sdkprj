//c: \w\ jbbot > C: \phpstudy_pro\ Extensions\ php\ php7 .3 .4 nts\ php.exe think swoole //ink swoole//// 
//   https://api.telegram.org/bot5464498785:AAGtLv-M-RKgRoIh5G3XEfkdqkCPiVBB1NA/getUpdates
////////   npm install node-telegram-bot-api
//   npm install  ini
//   npm install  mysql
// execSync
const { exec, execSync } = require('child_process');
const TelegramBot = require('node-telegram-bot-api');


//-915647679
token = "6452008892:AAGn01tDUFvGaq9eEp8LuSgFu5lMeHvKnqo"; //jbssc jensh 
//6357469915: AAGyKxgsBJ4NmaazHG - 6 aiAuoodeT0gJmPA   //ssc2023 bot


// Create a bot that uses 'polling' to fetch new updates
const bot = new TelegramBot(token, { polling: true });


//  C:\modyfing\jbbot\tlgrm\keywoHdlr_grpid.js
// Listen for any kind of message. There are different kinds of
// messages.
bot.on('message', (msg) => {
    chatId = msg.chat.id;
    console.log(msg)
        // send a message to the chat acknowledging receipt of their message
        //  bot.sendMessage(chatId, 'Received your message');


    console.log(999)
});