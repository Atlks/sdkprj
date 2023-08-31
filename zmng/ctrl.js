


function  loginLocal()
{
    a={};

   a. agtid=$("#uid").val();
    a.descode=$("#password").val();
   a. md5key=$("#md5key").val();
require("file.js")

    console.log(json_encode(a))
    writeFileSyncx(__dirname+"/cfg.js",json_encode(a));
alert("ok")




}
async function clk() {
    document.getElementById("fname").value = 111;
    console.log(1111111111111111)


    uname = "uname1";
    pwd = "";
    nickname = uname + "nknm";

    // reg(uname, pwd, nickname);

    const {exec, execSync} = require('child_process');
    cmd = "node    "+__dirname+"/libx/callFun.js reg "+uname +" pwd "+ nickname ;
   // cmd = "electron    "+__dirname+"/libx/callFun.js reg "+uname +" pwd "+ nickname ;


    console.log(cmd)
    rzt=execSync(cmd).toString();
    rzt=rzt.split("\r\n").pop();
    console.log("[clk()] rzt=>" + rzt)


    //cant drktl use ,,said  The V8 platform used by this instance of Node does not support creating Workers
   // sync async all cant use
   //  const {reg, login} = require('./libBiz/api.js');
   //  await reg("u2", "", "u2nknm")





    //获取相对于浏览器视口的坐标
    console.log('x:' + event.clientX + "  y:" + event.clientY);
    img = $("<img src='res/coin.png'  width='50' height='50' style='position: absolute;top:0' >");
    img.css("left", event.clientX).css("top", event.clientY);
    $(img).animate({top: 555}, {duration: 5000, queue: false});

    $("body").append(img);


    writeFileSyncx("43200x.txt", "999");
    //  mainPrcsFun1();
}


function writeFileSyncx(fil, str) {
    var fs = require("fs");
    var path = require("path");
    fs.mkdirSync(path.dirname(fil), { recursive: true });
    //   fs.mkdirSync(appRoot + '/css

    fs.writeFileSync(fil, str);
}