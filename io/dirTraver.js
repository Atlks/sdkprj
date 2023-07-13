/**
 * Created by Administrator on 2017/1/20.
 */
function main(){
    traveFileList("c:\\0picSaveDir",trverAftFun);

}
function trverAftFun(fileObj)
{
    var sM = require("../../com.attilax/core/str.js");
    if(sM.contain( fileObj.filename,"="))
    {
        var old=fileObj.path+pathM.sep+fileObj.filename;
        var newname=sM.replaceAll( fileObj.filename, /=/g,"%3d");
        var f=fileObj.path+pathM.sep+newname;
        fs.rename(old,f);
        console.log(f);
    }


}

var fs = require('fs');
function readFileList(path, filesList) {
    var files = fs.readdirSync(path);
    files.forEach(function (itm, index) {
        var stat = fs.statSync(path +"/"+ itm);
        if (stat.isDirectory()) {
            //????????
            readFileList(path+"/"+  + itm , filesList)
        } else {

            var obj = {};//??????????????????¡¤????????
            obj.path = path;//¡¤??
            obj.filename = itm//????
            filesList.push(obj);
        }

    })

}
var pathM = require('path');
function traveFileList(path, filesListFun) {
    var files = fs.readdirSync(path);
    files.forEach(function (itm, index) {
        var stat = fs.statSync(path +"/"+ itm);
        if (stat.isDirectory()) {
            //????????
            var new_dir=path+ pathM.sep  + itm;
            traveFileList(new_dir , filesListFun)
        } else {

            var obj = {};//??????????????????¡¤????????
            obj.path = path;//¡¤??
            obj.filename = itm//????
            filesListFun(obj);
        }

    })

}
var getFiles = {
//??????????????????  ÎªÊ²Ã´
    getFileList: function (path) {
        var filesList = [];
        readFileList(path, filesList);
        return filesList;
    },
    //?????????????????
    getImageFiles: function (path) {
        var imageList = [];

        this.getFileList(path).forEach((item) => {
            var ms = image(fs.readFileSync(item.path + item.filename));

        ms.mimeType && (imageList.push(item.filename))
    });
return imageList;

}
};


function   getFileListV2(path) {
    var filesList = [];
    readFileList(path, filesList);
    return filesList;
}
main();