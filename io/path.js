// JavaScript Document
// alert(getNameWzExt("c:\\fff\\t.txt"));

var fs = require('fs');
var path = require('path');
//创建多层文件夹 同步  mode =0777  default
function mkdirsSync(dirpath, mode) {

    if (!fs.existsSync(dirpath)) {
        var pathtmp;
        dirpath.split(path.sep).forEach(function(dirname) {
            if (pathtmp) {  //normal
                pathtmp = path.join(pathtmp, dirname);
            }
            else {  //first time
                pathtmp = dirname;
            }
            if (!fs.existsSync(pathtmp)) {
                if (!fs.mkdirSync(pathtmp, mode)) {
                    return false;
                }
            }
        });
    }
    return true;
}
function mkdirsSync_byfilepath(new_file_path_full, mode) {

    var new_file_path_NoFilename=getDirV2(new_file_path_full);
    return    mkdirsSync(new_file_path_NoFilename,mode);
  //  return true;
}


function addSuffix(f,suffix)
{ var path = require('path');
    var outputDir=getDir(f);
    var outputFile=getNameNoExt(f)+suffix+"."+getExt(f);
    var outFull=outputDir+path.sep+outputFile;
    return outFull;
}
function getExt(fpath)

{
   fpath=getNameWzExt(fpath);
    var idx=	fpath.lastIndexOf(".");

    return fpath.substr(idx+1);

}
function getExttoLowerCase(fpath) 

{
   fpath=getNameWzExt(fpath);
    var idx=	fpath.lastIndexOf(".");

    return fpath.substr(idx+1);

}
function main()
{
var s="C:\\debug\\node.js"
    console.log("--tr line:"+getNameNoExt(s));
}
//main();
function getNameNoExt(fpath)

{
    fpath=getNameWzExt(fpath);
    var idx=	fpath.lastIndexOf(".");

    return fpath.substr(0,idx);

}

function delExtName(f)
{
    var dir=getDirV2(f);
    var path = require('path');
    var name_noExt=getNameNoExt(f);
    return dir+path.sep+name_noExt;

}



function getNameWzExt(fpath)

{
	//fpath=fpath.replace("\\\\","\\/");
 //	alert(fpath);
    var path = require('path');
var idx=	fpath.lastIndexOf(path.sep);

return fpath.substr(idx+1);
	
}

function getDir(filePath)
{
    var path = require('path');

    var dir=filePath.substring(0,filePath.lastIndexOf(path.sep)+1);
    return dir;
}

function getDirV2(filePath)
{
    var path = require('path');

    var dir=filePath.substring(0,filePath.lastIndexOf(path.sep));
    return dir;
}
function getDir_test()
{

}


    exports.addSuffix = addSuffix;

    exports.getDir = getDir;
    exports.getDirV2 = getDirV2;
    exports.getsExt = getExt; exports.getExt = getExt;
    exports.getNameNoExt = getNameNoExt;
    //////333rrrddeeeee333eee

    exports.getNameWzExt = getNameWzExt;
    exports.delExtName = delExtName;
    exports.mkdirsSync = mkdirsSync;
    exports.mkdirsSync_byfilepath = mkdirsSync_byfilepath;


s="c:\\00orgSave\\url%www.tuicool.com    %2fa\\_1496297606341.html";console.log(s);
mkdirsSync_byfilepath(s);
console.log("--f")
console.log("ab\\cd/ef".replace("\\","").replace("/",""))


