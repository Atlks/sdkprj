const { exec } = require('child_process');
const TelegramBot = require('node-telegram-bot-api');

// replace the value below with the Telegram token you receive from @BotFather
//token = '6367905200:AAH0KUIu5uVKKCPWYi-aClaNW4lK9p-Rsps';
//token = "6424319932:AAFuKlo4dxeraUYhiF1EY6PEn2ozTBVIYbc"; //nnbot
token = '6134198347:AAEdHZUkmYrpm0RHUrzZaKK9d11SiEIhSUk'; //msg2024 nml msg recv 

//6357469915: AAGyKxgsBJ4NmaazHG - 6 aiAuoodeT0gJmPA   //ssc2023 bot

const bot = new TelegramBot(token, { polling: true });


const args = process.argv.slice(2)
parm = args[0];
parm = decodeURI(parm)
msg = JSON.parse(parm);

chatId = msg.chat.id;
console.log(msg);
//bot.sendMessage(chatId, JSON.stringify(msg));


var xiazhuAmt = msg.text.match(/\d+/g)[0];
var bal = 999;
reply = '成功投注，下注内容:' + msg.text + "\r\n";
var uid = msg.from.id;
var fstnm = msg.from.first_name;
reply = "\r\n" + reply + `${fstnm} --  ${uid}\r\n`;
reply = "\r\n" + reply + `\r\n下注:${xiazhuAmt}\r\n` + `已押：${xiazhuAmt}\r\n余额:${bal}`


bot.sendMessage(chatId, reply);

//redisbal
var uid = msg.from.id;
cmd = `reduce_bal uid=${uid} rdcAmt=${xiazhuAmt}`;
console.log(cmd);

function myFunc(arg) {
    process.exit(999)
}

setTimeout(myFunc, 5000, 'funky');