 // npm i electron
 //   C:\w\sdkprj\node_modules\electron\dist\electron.exe  C:\w\sdkprj\0dsktpapp\main.js

 const { app, BrowserWindow } = require('electron')

 function createWindow() {
     // 创建浏览器窗口
     const win = new BrowserWindow({
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

 function mainPrcsFun1() {
     console.log('mainPrcsFun1')
 }
 //window.mainPrcsFun1 = mainPrcsFun1;