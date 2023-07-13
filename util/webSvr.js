/**
 * Created by Administrator on 2017/2/1.
 */
 var requireAti = function(path){
	   
	 var pathObj = require(path);
	// var pwd = pathObj.resolve();
	// delete require.cache[pwd];
	 
	 
	 fullpath=require.resolve(path);
	 console.log("--fullpath:"+fullpath);
    if(require.resolve(path)){
			require.cache[path] = null;//not teke effect
		require.cache[fullpath] = null;//not teke effect
        delete require.cache[require.resolve(path)]; //jeig haosyao cant .
		delete require.cache[path]; //jeig haosyao cant .
        require(path);
		console.log("--fullpath require:"+fullpath);
    }else
	{
		console.log("--first require:"+path);
		 require(path);
	}
	
	  delete require.cache[require.resolve(path)]; //jeig haosyao cant .
		  require(path);  require(require.resolve(path));
};
function requireAti2(path)
{
	  delete require.cache[require.resolve(path)];
	return require(path);
}
 function openTmpPic(req, res)
{
    var fsrMode = require("../com.attilax/ui/FileSelector.js");
    var fsr=new fsrMode.FileSelector();
    fsr.folderSelector(function(path){
        res.send(path);
    })
}


var path = require('path');
var express = require('express');
var app = express();
console.log("__dirname:"+__dirname)
webroot=path.join(__dirname, '../..');
console.log("webroot:"+webroot)

//return;

app.use(express.static(webroot));

app.get('/', function(req, res) {
    res.send('Hello world');
});

app.get('/backcall.ati', function(req, res) {
 //   reqG=
    var meth=req.query.meth;
    eval(meth+"(req,res)");
    var p1=req.query.p1
    console.log("---p:"+p1);
 //   res.send('Hello world');
});
// C:\Users\Administrator\AppData\Local\Google\Chrome\Application\chrome.exe --app=http://localhost:8088/imgSearch/imgSearch.html
app.get('/dirlist', function(req, res) {
		var mod = requireAti2("../../carema/cameraBiz.js");
		console.log("--mod:"+mod);
	mod.dirlistHandler(req,res);
	
});



var server = app.listen(8088, function() {
    console.log('Express is listening to http://localhost:8088');
});


return;
/*
var fsrMode = require("../com.attilax/ui/FileSelector.js");
var fsr=new fsrMode.FileSelector();
fsr.folderSelector(function(path){
    //   res.send(path);
    console.log("--path:"+path)
})
*/