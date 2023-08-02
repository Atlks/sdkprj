//c: \w\ jbbot > C: \phpstudy_pro\ Extensions\ php\ php7 .3 .4 nts\ php.exe think swoole //ink swoole//// 
//   https://api.telegram.org/bot5464498785:AAGtLv-M-RKgRoIh5G3XEfkdqkCPiVBB1NA/getUpdates
////////   npm install node-telegram-bot-api

// execSync
const { exec } = require('child_process');
const TelegramBot = require('node-telegram-bot-api');

// replace the value below with the Telegram token you receive from @BotFather
//token = '6367905200:AAH0KUIu5uVKKCPWYi-aClaNW4lK9p-Rsps';
//token = "6424319932:AAFuKlo4dxeraUYhiF1EY6PEn2ozTBVIYbc"; //nnbot
token = '6540014740:AAHLjeevuyWdzyMEoXxX9GRTE1nUs4hc_pI'; //rcvmsg   rcvbot_bot
token = '6605810782:AAF-V8dXriqJJxTaOfVxmf5KQY5S_P9yLs8'; //jbnn chk bot

//token = '6648133077:AAFO0flf9bzoGxeWsQ_ugWpyHoelJLjwq1U'; //jbhash chkbot


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
    $phpexe = "C:\\phpstudy_pro\\Extensions\\php\\php8.0.2nts\\php.exe";
    // $tlghr_msg_hdl = " C:\\w\\jbbot\\tlgrmHdl_temacyo.php ";
    cmd = $phpexe + "   tlgrm/tlgrmHdl_temacyo.php " + encodeURI(JSON.stringify(msg));
    console.log(cmd)
    exec(cmd)
    console.log(999)
});