// C:\w\sdkprj\node_modules\electron\dist\electron.exe  C:\w\sdkprj\agt\dsktp.js


/////------------- stgart web
const express = require('express')
const app_web = express()

// respond with "hello world" when a GET request is made to the homepage
app_web.get('/', (req, res) => {
    res.send('okkk')
})

app_web.get('/about', (req, res) => {
    res.send('about')
})


console.log(77)

var server = app_web.listen(80, function () {

    var host = server.address().address
    var port = server.address().port

    console.log("应用实例，访问地址为 http://localhost:%s", host, port)

})

console.log(999999)

//-------------start win

const {
    app, BrowserWindow,
    Menu,
    Tray
} = require('electron')

function createWindow() {
    // 创建浏览器窗口
    const win = new BrowserWindow({
        icon:"res/icon.jpg",
        width: 800,
        height: 600,
        webPreferences: {
            nodeIntegration: true,
            contextIsolation: false,
            enableRemoteModule: true
        }
    })

    // 并且为你的应用加载index.html
    win.loadFile('index.html')
     win.openDevTools();
    creatTray();

    // setTimeout(function (){
    //
    //
    //     app.quit();
    //     app.quit();
    //     app.exit()
    // },5000)

}


// Electron会在初始化完成并且准备好创建浏览器窗口时调用这个方法
// 部分 API 在 ready 事件触发后才能使用。
app.whenReady().then(createWindow)

//当所有窗口都被关闭后退出
app.on('window-all-closed', () => {
    // 在 macOS 上，除非用户用 Cmd + Q 确定地退出，
    // 否则绝大部分应用及其菜单栏会保持激活。
    if (process.platform !== 'darwin') {
        app.quit()
    }
})


//-----------------托盘图标
function creatTray() {


    //设置托盘图标和菜单
    var trayMenuTemplate = [
        {
            label: '打开',
            click: () => {
                mainWindow.show();
            }
        },
        {
            label: '退出',
            click: () => {
                app.quit();
                app.quit();//因为程序设定关闭为最小化，所以调用两次关闭，防止最大化时一次不能关闭的情况
            }
        }
    ];
    //系统托盘图标
    appTray = new Tray('res/icon.jpg')
    //图标的上下文菜单
    const contextMenu = Menu.buildFromTemplate(trayMenuTemplate);
    //设置此托盘图标的悬停提示内容
    appTray.setToolTip('我的托盘图标');
    //设置此图标的上下文菜单
    appTray.setContextMenu(contextMenu);
    //单击右下角小图标显示应用左键
    appTray.on('click', function () {
       // mainWindow.show();
    })
    //右键
    appTray.on('right-click', () => {
        appTray.popUpContextMenu(trayMenuTemplate);
    });

}

function mainPrcsFun1() {
    console.log('mainPrcsFun1')
}

//window.mainPrcsFun1 = mainPrcsFun1;