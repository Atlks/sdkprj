libdir = getLibdir()


function getLibdir() {
    console.log("_file=>" + __filename)  //if in html file ,...just for html file path
    //   console.log(__dirname)
    libdir = __dirname + '/../libx/'
// C:\modyfing\jbbot\zmng/../lib/
    console.log(libdir)

    const fs = require('fs');

    console.log("exist dir:=>" + fs.existsSync(libdir))

    if (!fs.existsSync(libdir)) {
        console.log(libdir + " not exist")
        libdir = __dirname + '/libx/'
    }
    console.log("libdir=>" + libdir)
    return libdir;
}

var {
    isset,
    echo,
    substr,
    console_log,
    sprintf,
    startwith,
    str_replace,
    strtolower,
    strlen,
    strpos,
    trim,
    sprintf, time
} = require(libdir + 'php.js');
const {http_get} = require(libdir + 'http.js');
const {aes_encrypt, aes_decrypt, aes_mode_ECB, aes_mode_CBC} = require(libdir + 'aes.js');

const {urlencode, md5} = require(libdir + 'enc.js');
 require("api2023jb.js")
const fs = require("fs");
global["reg"] = reg;
global["login"] = login;

require("fp_ati1990");


// uname = "uname1"
// nickname = uname + "nknm";
// pwd = "";
//reg(uname, pwd, nickname);


async function main() {
    const args = process.argv.slice(2)
    echo("**********callFun.js prm==>" + args)
    echo("\r\n")
     $rz=await call_user_func(args[0],process.argv.slice(3))
   // $rz = "99999"
    echo("88888888888888888888888888")
    echo($rz);
    //  app.quit(); app.quit();
    // console.log(777);

     process.exit()
}

main();

// function createWindow() {
//     // 创建浏览器窗口
//     const win = new BrowserWindow({
//         // icon:"res/icon.jpg",
//         width: 800,
//         height: 600,
//         webPreferences: {
//             nodeIntegration: true,
//             contextIsolation: false,
//             enableRemoteModule: true
//         }
//     })
//
//     // 并且为你的应用加载index.html
//     // win.loadFile('index.html')
//     // win.openDevTools();
//
//
//     setTimeout(function () {
//
//
//         app.quit();
//         app.quit();
//         app.exit()
//     }, 5000)
//
// }


// Electron会在初始化完成并且准备好创建浏览器窗口时调用这个方法
// 部分 API 在 ready 事件触发后才能使用。
//app.whenReady().then(createWindow)
// setTimeout(function (){
//
//
//     app.quit();
//     app.quit();
//     app.exit()
// },5000)

// reg u2 pwd u2nknm


    //  process.kill(process.pid, 'SIGTERM')
    //  console.log(888);
    //  app.exit()

    //must use timer to close ,maybe in async thread..

    // setTimeout(function (){
    //
    //
    //     app.quit();
    //     app.quit();
    //     app.exit()
    // },100)

    //close21();

    //app.exit();
    // app.quit();//因为程序设定关闭为最小化，所以调用两次关闭，防止最大化时一次不能关闭的情况



// electron  --unhandled-rejections=strict  C:\modyfing\jbbot\zmng/libx/callFun.js reg uname1 pwd uname1nknm

// function close21() {
//     app.exit();
// }
//
// const {
//     app, BrowserWindow,
//     Menu,
//     Tray
// } = require('electron')
//

// app.on('window-all-closed', () => {
//
//
//     app.quit();
//     app.quit();
//
// })
