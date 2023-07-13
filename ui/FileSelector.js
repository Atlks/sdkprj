/**
 * Created by Administrator on 2017/2/1.
 */

function FileSelector()
{

}

FileSelector.prototype.folderSelector= function (callbk) {
    f=__dirname+"/../../fileselect\\FileSelectFolder.exe";
    var fs = require('fs');
    var path = require('path');
    exstStt=fs.existsSync(f)
    var Prcs = require("../core/process.js");
    var prc=new Prcs.Process();
    var ret="";
    prc.exec(f,function(line){
        ret+=line;
    },function(){

        callbk(ret);
    })


}

try{
    module.exports.FileSelector = FileSelector;
}catch(e)
{

}