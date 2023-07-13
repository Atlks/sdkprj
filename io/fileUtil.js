/**
 * Created by Administrator on 2017/1/18.
 * 汉字 中文
 */



var libpath=__dirname+"/../";
var pathUtil = require(libpath+"io/path.js");
var strModule = require(libpath+"text/str.js");
/** fileUtil.js
 * Created by Administrator on 2017/1/14.
 */
function getEspCharArray_fileNameEncode()
{


    var  mp ={};
    mp["*"]= "%2A";

    var  as = strModule.SplitByNone("/\\:?<>\"|\r\n");

    for (  s of  as) {

        mp[s]= encodeURIComponent(s);


}
    return mp;

}
var fs = require('fs');
function copy(src, dst) {
    fs.writeFileSync(dst, fs.readFileSync(src));
}

function  fileNameEncode( filenameOri) {
    // /\:* <>\"|
    if(filenameOri==("."))
        return "%2E";
    if(filenameOri==(".."))
        return "%2E%2E";

  var mp=  getEspCharArray_fileNameEncode()
   var as = strModule.SplitByNone(filenameOri);
    var fname2 = "";
    for (var s of  as) {
        fname2 += mp[s] == null ? s : mp[s];
    }
    return fname2;
}
//console.log( fileNameEncode(  " aa\"bb  " ));

var fs = require('fs');

//fs.writeFileSync("c:\\00orgSave\\www.51cto.com\\Android安全防护之旅---应用"反调试"操作的几种方案解析_1496310115700.htm", bin_data);



function toCharArr(file_full_path) {
  var rzt=new Array();
    // jeig readfile yaosi encode bdwi ,,no ex,,,only data is empty  undife ,
    // 其encoding参数是不支持gbk的  ansi ya cant.. only utf8
    var data = fs.readFileSync(file_full_path, 'utf8');
    console.log("readFileSync::"+ data)
    //throw "die";
    for(var i=0;i<data.length;i++)
    {
        var char=data.charAt(i);
        rzt.push(char);
    }
    return rzt;

}
function trave_scandir_readdirSync(path, filesListProcessorHandler) {
    var pm=require("path");
    if(path==NaN)
        return;
    console.log(" will readFileList path:"+path);
    var files = fs.readdirSync(path);
    files.forEach(function (fname, index) {
        if(fname=='yunprint')
            console.log("debg");
        if(fname==NaN)
            return;
        var fullname = path + pm.sep+ fname;
        console.log("-- foreach path or file :"+fullname);
        var stat = fs.statSync(fullname);

        if (stat.isDirectory()) {
            //�ݹ��ȡ�ļ�
            //
            var fullpath2 = path+ pm.sep+   fname;
            console.log("--is dir:"+ fullpath2);

            readdirSync_scandir(fullpath2 , filesListProcessorHandler)
        } else {

            var obj = {};//����һ���������ļ���·��������
            obj.path = path;//·��
            obj.filename = fname//����
            filesListProcessorHandler (obj);
        }

    })

}

function readdirSync_scandir(path, filesListProcessorHandler) {
    var pm=require("path");
    if(path==NaN)
        return;
	console.log(" will readFileList path:"+path);
    var files = fs.readdirSync(path);
    files.forEach(function (fname, index) {
        if(fname=='yunprint')
           console.log("debg");
        if(fname==NaN)
            return;
        var fullname = path + pm.sep+ fname;
        console.log("-- foreach path or file :"+fullname);
        var stat = fs.statSync(fullname);

        if (stat.isDirectory()) {
            //�ݹ��ȡ�ļ�
            //
            var fullpath2 = path+ pm.sep+   fname;
            console.log("--is dir:"+ fullpath2);

            readdirSync_scandir(fullpath2 , filesListProcessorHandler)
        } else {

            var obj = {};//����һ���������ļ���·��������
            obj.path = path;//·��
            obj.filename = fname//����
            filesListProcessorHandler (obj);
        }

    })

}

function readFileList(path, filesList) {
    var pm=require("path");
    if(path==NaN)
        return;
	console.log(" will readFileList path:"+path);
    var files = fs.readdirSync(path);
    files.forEach(function (fname, index) {
        if(fname=='yunprint')
           console.log("debg");
        if(fname==NaN)
            return;
        var fullname = path + pm.sep+ fname;
        console.log("-- foreach path or file :"+fullname);
        var stat = fs.statSync(fullname);

        if (stat.isDirectory()) {
            //�ݹ��ȡ�ļ�
            //
            var fullpath2 = path+ pm.sep+   fname;
            console.log("--is dir:"+ fullpath2);

            readFileList(fullpath2 , filesList)
        } else {

            var obj = {};//����һ���������ļ���·��������
            obj.path = path;//·��
            obj.filename = fname//����
            filesList.push(obj);
        }

    })

}


function trave(path, filesListHandler) {
    var pm=require("path");
    var files = fs.readdirSync(path);
    files.forEach(function (itm, index) {
        var stat = fs.statSync(path + pm.sep+ itm);
        filesListHandler(stat,path,itm);


    });

}
var getFiles = {
//��ȡ�ļ����µ������ļ�  为什么
    getFileList: function (path) {
        var filesList = [];
        readFileList(path, filesList);
        return filesList;
    },
    //��ȡ�ļ����µ�����ͼƬ
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

function parseByCcheerio(html) {
    //var cheerio =require('cheerio');
    var $ = cheerio.load('<tr id="fruits">...</tr>');
    //       var $ = cheerio.load(data);
    $("tr").each(function(i, e) {
        console.log($(e).text());
    });
}



function parseByNodeJq(html)
{
    var jsdom = require("jsdom");
    $ = require("jquery")(jsdom.jsdom().defaultView);
    //only low ver can this
    //  var $ = require('jquery');
    var $doc = $(html);
    //  console.log("No. name language star  forks ")
    $doc.find("tr").each(function(i,project){
        var $project = $(project);
        var text=$project.text();
        //    var forks = $project.find("li.forks").text().trim();
        if(text.indexOf("511")>0)
        {
            text=text.trim();
            text=replaceEnter2Empty(text);
            text=replaceTab2Empty(text);
            text=  removeToomanySpacechar(text,800);
            //      text=text.replace("  "," ");
            text=text.replace("\n"," ");
            console.log("--tr line:"+text);
        }

    });

}
//main
function main(){
    var dir="c:\\00orgSave";
    var fls=getFileListV2(dir);
    for(idx in fls)
    {
        /**
         * { path: 'c:\\00orgSave',
  filename: 'index_P57_1484408092882.html' }
         */
        var f=fls[idx];
        var f_str= f.path+"/"+ f.filename;
        var data=fs.readFileSync(f_str,"utf-8");
        parseByNodeJq(data);

        //   console.log(f);
    }
}



//替换所有的回车换行
function TransferString(content)
{
    var string = content;
    try{
        string=string.replace(/\r\n/g,"<BR>")
        string=string.replace(/\n/g,"<BR>");
    }catch(e) {
        alert(e.message);
    }
    return string;
}
function replaceEnter2Empty(content)
{
    var string = content;
    try{
        string=string.replace(/\r\n/g," ")
        string=string.replace(/\n/g," ");
    }catch(e) {
        alert(e.message);
    }
    return string;
}
function replaceTab2Empty(content)
{
    var string = content;
    try{
        string=string.replace(/\t/g," ")

    }catch(e) {
        alert(e.message);
    }
    return string;
}


function removeToomanySpacechar(t,time)
{
    for(var i=0;i<time;i++)
    {
        t= t.replace("  "," ");
    }
    return t;

}
 
function mkdirsSync_byFilePath(FilePath)
{
    var pasM=require("./path.js");
    var fs = require('fs');
    var path = require('path');
    var dir=pasM.getDir(FilePath);
    console.log("---"+dir)
    mkdirsSync(dir);
}
//��������ļ��� ͬ��
function mkdirsSync(dirpath, mode) {
    var fs = require('fs');
    var path = require('path');
    if (!fs.existsSync(dirpath)) {
        var pathtmp;
        dirpath.split(path.sep).forEach(function(dirname) {
            if (pathtmp) {
                pathtmp = path.join(pathtmp, dirname);
            }
            else {
                pathtmp = dirname;
            }
            if (!fs.existsSync(pathtmp)) {
                console.log(" not exist dir,will be create:"+pathtmp)
                if (!fs.mkdirSync(pathtmp, mode)) {
                    return false;
                }
            }
        });
    }
    return true;
}

function exportTag(){}

    exports.mkdirsSync = mkdirsSync;
    exports.mkdirs = mkdirs;  //asyn
    exports.mkdir_auto_next = mkdir_auto_next;  //asyn   digui

    exports.mkdirsSync_byFilePath = mkdirsSync_byFilePath;

    exports.getFileListV2 = getFileListV2;  //
    exports.traveExptTag=trave;
    exports.toCharArr=toCharArr;
exports.copy=copy;
exports.fileNameEncode=fileNameEncode;
exports.readdirSync_scandir=readdirSync_scandir;

exports.trave=trave;
exports.trave_scandir_readdirSync=trave_scandir_readdirSync;

//��������ļ��� �첽
function mkdirs(dirpath, mode, callback) {
    callback = callback ||
        function() {};

    fs.exists(dirpath,
        function(exitsmain) {
            if (!exitsmain) {
                //Ŀ¼������
                var pathtmp;
                var pathlist = dirpath.split(path.sep);
                var pathlistlength = pathlist.length;
                var pathlistlengthseed = 0;

                mkdir_auto_next(mode, pathlist, pathlist.length,
                    function(callresult) {
                        if (callresult) {
                            callback(true);
                        }
                        else {
                            callback(false);
                        }
                    });

            }
            else {
                callback(true);
            }

        });
}

// �첽�ļ��д��� �ݹ鷽��
function mkdir_auto_next(mode, pathlist, pathlistlength, callback, pathlistlengthseed, pathtmp) {
    callback = callback ||
        function() {};
    if (pathlistlength > 0) {

        if (!pathlistlengthseed) {
            pathlistlengthseed = 0;
        }

        if (pathlistlengthseed >= pathlistlength) {
            callback(true);
        }
        else {

            if (pathtmp) {
                pathtmp = path.join(pathtmp, pathlist[pathlistlengthseed]);
            }
            else {
                pathtmp = pathlist[pathlistlengthseed];
            }

            fs.exists(pathtmp,
                function(exists) {
                    if (!exists) {
                        fs.mkdir(pathtmp, mode,
                            function(isok) {
                                if (!isok) {
                                    mkdir_auto_next(mode, pathlist, pathlistlength,
                                        function(callresult) {
                                            callback(callresult);
                                        },
                                        pathlistlengthseed + 1, pathtmp);
                                }
                                else {
                                    callback(false);
                                }
                            });
                    }
                    else {
                        mkdir_auto_next(mode, pathlist, pathlistlength,
                            function(callresult) {
                                callback(callresult);
                            },
                            pathlistlengthseed + 1, pathtmp);
                    }
                });

        }

    }
    else {
        callback(true);
    }

}