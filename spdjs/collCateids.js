// coll cateid
name='hornhub_cate55'
console.log (name.indexOf('hornhub_cate'))
const fs = require("fs");
const path = require('path');

//设置根目录
var root = 'D:\\prj\\dataCateTest';

var arr = [];
let set = new Set(); //或者 new Set(null);
//获取此文件夹下所有的文件(数组)
var files = fs.readdirSync(root);

//遍历这些文件或者文件夹
for(var i=0;i<files.length;i++){
  fname=files[i];
  if(fname.indexOf('hornhub_cate')>=0)
  {
      last=fname.indexOf('_page');
      console.log(fname)
      console.log( fname.substring(12,last))
      catid=fname.substring(12,last)

      arr.push(catid)
      set.add(catid);

  }else
  continue;
    
    //为文件创建一个描述对象
    var filePath = {};
    //添加name属性
    filePath.name = files[i];
    var fileStat = fs.statSync(path.join(root,files[i]));
    //判断是否是文件夹
    if(fileStat.isDirectory()){
        //文件夹类型则添加type属性为dir
        filePath.type = 'dir';
    }else{
        //文件类型则添加type属性为文件后缀名
        filePath.type = path.extname(files[i]).substring(1);
    }
    //将对象添加到数组中
  //  arr.push(filePath);
}
//将数组转换成字符串后写入data.txt文件中保存
fs.writeFileSync('./data.txt', JSON.stringify(arr))

console.log("--F")


console.log(  Array.from(set) )
console.log( Array.from(set).join(','))

console.log( Array.from(arr).sort(function(a, b){return a - b}).join(','))