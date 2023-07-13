/**
 * Created by Administrator on 2017/1/14.
 */


var fs = require('fs');
function readFileList(path, filesList) {
    var files = fs.readdirSync(path);
    files.forEach(function (itm, index) {
        var stat = fs.statSync(path +"/"+ itm);
        if (stat.isDirectory()) {
            //�ݹ��ȡ�ļ�
            readFileList(path+"/"+  + itm , filesList)
        } else {

            var obj = {};//����һ���������ļ���·��������
            obj.path = path;//·��
            obj.filename = itm//����
            filesList.push(obj);
        }

    })

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
main();