/**
 * Created by Administrator on 2017/5/21.
 */

var filM = require("./fileUtil.js");

function hadler(stat,path,fname)
{
    if (stat.isDirectory())
    {
        var pm=require("path");
        var newDir=  "c:\\ati_struts" + pm.sep+ fname;

        console.log(  "c:\\ati_struts" + pm.sep+ fname );
        var fs = require('fs');

        console.log(fs);  fs.mkdir(newDir );
     //   fs.mkdirsSync_byFilePath(newDir);
   //     fs.mkdirs(newDir);

    }

}
filM.traveExptTag("c:\\ati",hadler);

