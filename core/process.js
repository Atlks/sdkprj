/**
 * Created by Administrator on 2017/1/31.
 * ns process
 */


function Process()
{
 this.dbg=false;
}
//var Process = function(){}


Process.prototype.list=function()
{
    var cmd="";
    this.exec(cmd,function(line){

    },function(code){

    })
}

Process.prototype.exec=function(cmd,stdout_data_fun,exit_fun)
{
    var pM = require("../../com.attilax/io/path.js");
//    var cmd = 'D:\\0workspace\\Tesseract\\tesseract.exe "@jpg@"  "@rztName@" -l chi_sim';

   ;
    console.log('-----cmd data:' + cmd);
    var iconv = require('iconv-lite');
    var exec = require('child_process').exec;
    var exeHandler = exec(cmd, {
        encoding: "binary"
    });

    exeHandler.stdout.on('data', function (stdout_data) {
        var str = iconv.decode(stdout_data, 'GBK');
        if(this.dbg)
        console.log('-----stdout_data data:' + str);
        stdout_data_fun(str);
    });
//note ,if many data,,exit event maybe bef the data event ..,in many line data ret .should use timeout ..
    exeHandler.on('exit', function (code) {
        console.log('---exit code:' + code);


        exit_fun(code);
    });
}


Process.prototype.listNgrep=function(grepWord,retFun)
{
    var li=new Array();
    var cmd="wmic process get name";

    this.exec(cmd,function(lines){
        var a=lines.split("\r\n");
        for(idx in a)
        {
            var line=a[idx];
            line=line.replace("\r","");
            var logstr="line.indexOf_grepWord_, line:"+line;
            logstr+=", indexof:"+line.indexOf(grepWord);
            logstr+=", rzt:"+(line.indexOf(grepWord)>=0);
            console.log(logstr);
            var idx2=line.indexOf(grepWord);
            if(idx2>=0)
            {
                 console.log("--will add"+line);
                li.push(line);
            }else{}

        }

    },function(code){
      //  retFun(li);
        setTimeout(function(){
            retFun(li);
        },1000);
    });

}


try{
    module.exports.Process = Process;
 }catch(e)
{

}