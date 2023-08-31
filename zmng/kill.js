

const {exec, execSync} = require('child_process');

uname = "uname1";
pwd = "";
nickname = uname + "nknm";
cmd = "electron    "+__dirname+"/libx/callFun.js reg "+uname +" pwd "+ nickname ;


console.log(cmd)
rzt=execSync(cmd).toString();
rzt=rzt.split("\r\n").pop();
console.log("[clk()] rzt=>" + rzt)