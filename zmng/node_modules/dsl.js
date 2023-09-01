


function  dsl_callFunCmdMode( )
{
    var funname = arguments.callee.name;
    // arguments.callee.name
    arg = JSON.stringify(arguments);
    console.log("*********=>" + funname + arg);

    arr=Array.from(arguments);
    cmdstr=arr.join(" ");
    console.log("cmdstr=>"+cmdstr)


    const {exec, execSync} = require('child_process');
    cmd = "node    "+__dirname+"/libx/callFun.js   "+cmdstr;
// cmd = "electron    "+__dirname+"/libx/callFun.js reg "+uname +" pwd "+ nickname ;


    console.log("cmd=>"+cmd)
    rzt=execSync(cmd).toString();
     rzt=rzt.split("88888888888888888888888888").pop();
    console.log("[dsl_callFunCmdMode] rzt=>" + rzt)
    return rzt;
}
//   uname=
//   score=

