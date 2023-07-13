/**
 * Created by Administrator on 2017/5/25.
 */

function md5file(path,endFunEvent)
{
var fs = require('fs');
var crypto = require('crypto');

//var path = '/target/file.data';
var start = new Date().getTime();
var md5sum = crypto.createHash('md5');
var stream = fs.createReadStream(path);
stream.on('data', function(chunk) {
    md5sum.update(chunk);
});
stream.on('end', function() {
    str = md5sum.digest('hex').toUpperCase();

    console.log('文件:'+path+',MD5签名为:'+str+'.耗时:'+(new Date().getTime()-start)/1000.00+"秒");
    endFunEvent(path,str);
});

}



var crypto = require('crypto');
//③加密的方法
function md5Encrypt(encryptString) {
    var hasher = crypto.createHash("md5");
    hasher.update(encryptString);
  var   rt= hasher.digest('hex');
    return rt;
}

try{

    exports.md5file=md5file;
    exports.md5=md5Encrypt;
}catch(e)
{

}