//c: \w\ jbbot > C: \phpstudy_pro\ Extensions\ php\ php7 .3 .4 nts\ php.exe think swoole //ink swoole//// 
//   https://api.telegram.org/bot5464498785:AAGtLv-M-RKgRoIh5G3XEfkdqkCPiVBB1NA/getUpdates
////////   npm install node-telegram-bot-api

$phpexe = "C:\\phpstudy_pro\\Extensions\\php\\php7.4.3nts\\php.exe";
$tlghr_msg_hdl = __dirname + "\\tlgrmHdl_debao.php ";
const token = '6367905200:AAH0KUIu5uVKKCPWYi-aClaNW4lK9p-Rsps';
//chkbot



bot = getTelegramBot(token);


bot.on('message', (msg) => {

    //   $msgx = msg.text;
    console.log(msg);
    bot.sendMessage(msg.chat.id, 'Received your message');


    $param_rf_addr = setVal(msg);
    execSyncx($phpexe + " " + $tlghr_msg_hdl + " " + $param_rf_addr);
    console.log(999)
});


























function setVal(Prm) {
    $fname = Math.random();
    writeFileSyncx("./tmp/" + $fname + ".json", JSON.stringify(Prm));
    return $fname;

}




function getTelegramBot(token) {
    const TelegramBot = require('node-telegram-bot-api');

    // replace the value below with the Telegram token you receive from @BotFather


    // Create a bot that uses 'polling' to fetch new updates
    const bot = new TelegramBot(token, { polling: true });

    return bot;
}



function writeFileSyncx(fil, str) {
    var fs = require("fs");
    var path = require("path");
    fs.mkdirSync(path.dirname(fil), { recursive: true });
    //   fs.mkdirSync(appRoot + '/css

    fs.writeFileSync(fil, str);
}



function execSyncx(cmd) {

    console.log(cmd);
    const { exec } = require('child_process');
    var execSync = require('child_process').execSync;



    try {
        const stdout = execSync(cmd)
        console.log(`stdout: ${stdout}`);

    } catch (err) {
        //not take effec
        console.log("output maybe err", err)
            // console.log("sdterr", err.stderr)
    }


    //   process.stderr.on('data', () => {
    //      console.log("stderr436", data);
    //   })
}