//c: \w\ jbbot > C: \phpstudy_pro\ Extensions\ php\ php7 .3 .4 nts\ php.exe think swoole //ink swoole//// 
//   https://api.telegram.org/bot5464498785:AAGtLv-M-RKgRoIh5G3XEfkdqkCPiVBB1NA/getUpdates
////////   npm install node-telegram-bot-api

// execSync
const { exec } = require('child_process');
const TelegramBot = require('node-telegram-bot-api');




token = "6510408569:AAHrrbsKgCvklwiFje_TKPF-ABMz0kdxn2c" // msg2025



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
    cmd = $phpexe + "   tlgrm/tgHdl.php " + encodeURI(JSON.stringify(msg));
    console.log(cmd)
    exec(cmd)
    console.log(999)
});