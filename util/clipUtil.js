function clrClip()
{
    var cmd = 'd:\\0workspace\\atiplat_eeJS\\setclip.exe "--clr"';
    var exeHandler = exec(cmd);
    exeHandler.on('exit', function (code) {
        console.log('--- clrClip exit code:' + code);
    });


}
    function getTxtFromClip(after_fun) {
//var arguments = process.argv.splice(2);
    var iconv = require('iconv-lite');
    var exec = require('child_process').exec;
//D:\0workspace\\clip.exe
    var cmd = 'd:\\0workspace\\atiplat_eeJS\\clip.exe';
    var exeHandler = exec(cmd, {
        encoding: "binary"
    });

    exeHandler.stdout.on('data', function (stdout_data) {
        var str = iconv.decode(stdout_data, 'GBK');
        console.log('-----clip data:' + str);
        after_fun(str);
    });

    exeHandler.on('exit', function (code) {
        console.log('---exit code:' + code);
    });

}

