//c: \w\ jbbot > C: \phpstudy_pro\ Extensions\ php\ php7 .3 .4 nts\ php.exe think swoole //ink swoole//// 
//   https://api.telegram.org/bot5464498785:AAGtLv-M-RKgRoIh5G3XEfkdqkCPiVBB1NA/getUpdates
////////   npm install node-telegram-bot-api


const TelegramBot = require('node-telegram-bot-api');

// replace the value below with the Telegram token you receive from @BotFather
//token = '6367905200:AAH0KUIu5uVKKCPWYi-aClaNW4lK9p-Rsps';
//token = "6424319932:AAFuKlo4dxeraUYhiF1EY6PEn2ozTBVIYbc"; //nnbot
token = '6134198347:AAEdHZUkmYrpm0RHUrzZaKK9d11SiEIhSUk'; //msg2024 nml msg recv 

//6357469915: AAGyKxgsBJ4NmaazHG - 6 aiAuoodeT0gJmPA   //ssc2023 bot


// Create a bot that uses 'polling' to fetch new updates
const bot = new TelegramBot(token, { polling: true });



// Listen for any kind of message. There are different kinds of
// messages.
bot.on('message', (msg) => {
    const chatId = msg.chat.id;

    // send a message to the chat acknowledging receipt of their message
    bot.sendMessage(chatId, 'Received your message');
    bot.sendMessage(chatId, JSON.stringify(msg));
    console.log(msg);
});