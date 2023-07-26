//  C:\phpstudy_pro\Extensions\php\php8.0.2nts\php.exe  composer.phar require amphp/react-adapter
console.log(999)
console.log("Before the setTimeout call")
let timerID = setTimeout(() => {
    console.log("Hello, World!")
    const { exec } = require('child_process');
// 输出当前目录（不一定是代码所在的目录）下的文件和文件夹
    cmd="C:\\phpstudy_pro\\Extensions\\php\\php8.0.2nts\\php.exe  C:\\w\\jbbot\\task1.php";
    console.log( cmd)
    exec(cmd, (err, stdout, stderr) => {
        if(err) {
            console.log(err);
            return;
        }
        console.log(`stdout: ${stdout}`);
        console.log(`stderr: ${stderr}`);
    });
    console.log( 666);

}, 3000);
console.log("After the setTimeout call")

// C:\phpstudy_pro\Extensions\php\php8.0.2nts\php.exe  composer require amphp/react-adapter