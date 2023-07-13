/**
 * Created by Administrator on 2017/5/25.
 */
function getDirMd5tag(dirNopath)
{
   var md5_mod = require("../encode/Md5Util.js");
   var s= md5_mod.md5(dirNopath);
   return s.substring(0,16);
}
var start_dir="C:\\0000tagpic";
console.log( new Date() ) ;
var tim_mod = require("../time/time.js");
console.log(  tim_mod.now_str__format_local_filename() ) ;

var pm = require("../io/path.js");
var pM = require("../io/path.js");
var md5_mod = require("../encode/Md5Util.js");
var filM = require("../io/fileUtil.js");
var fs = require('fs');
var fls=filM.getFileListV2(start_dir);

for(idx in fls)
{

   var f_obj = fls[idx];
  var  f=f_obj.path+"\\"+f_obj.filename;
  console.log(" cur file is:"+  JSON.stringify(f_obj)  );

 //  var  dir= f_obj.path;
       //pm.getDirV2( f);
   var  fname=pm.getNameNoExt(f_obj.filename);
   if(fname>9)continue;


 //  var  newfilepatn=dir+"/"+fname+"."+ext;

   md5_mod.md5file( f,  function(f2,md5str){
   //   console.log(md5str);
               var dir=pm.getDirV2(f2);
               var  fname=pm.getNameNoExt(f2);
               var ext=pm.getExt(f2);
               var f2_path=pm.getDirV2(f2);
               var Parent_dirname = pM.getNameWzExt(f2_path);
               var   Parent_dirname_md5=getDirMd5tag(Parent_dirname);
               var   newfilepatn=dir+"/"+Parent_dirname_md5 +"_" +fname+"_"+ md5str+"."+ext;

               console.log("------ cur name:"+ f2);
             console.log(" ------------new name:"+ newfilepatn);
               fs.rename(f2,newfilepatn,function(err){
                  if(err){
                     console.log("重命名失败！" +err);
                  }else{
                     console.log("重命名成功！"+err);
                  }
               });

   }  );

}  //end for

/*

path="C:\\0000tagpic\\01.jpg";
md5_mod.md5file( path,  function(md5str){
   console.log(md5str);
}  )
filepath="C:\\0000tagpic";
var filM = require("../io/fileUtil.js");
var fs = require('fs');
var stat = fs.statSync(filepath);
//console.log(" dir name :"+ stat)

var pM = require("../io/path.js");
var dirname = pM.getNameWzExt(filepath);
console.log("  dirname:"+dirname);

console.log("dirname MD5:"+  md5_mod.md5(dirname));

    */