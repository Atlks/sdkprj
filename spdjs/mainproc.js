//main proc
logmdx = require('./jsdk/log.js');
logger = logmdx.logger;
logger.info("this is a info msg");


var obj = {};
obj.cateid = 22; obj.cate = 33; 
  obj2str = JSON.stringify(obj);
//obj2str='testparam'
child_process= require('child_process')  
//child_process.fork("./detailDbInsert.js", [obj2str] ,{silent:true});

logger.info(" paramBef in mainthrd:"+ obj2str);
escapeParam=escape(obj2str);
logger.info(" escapeParam in mainthrd:"+ escapeParam);
child_process.exec('node ./detailDbInsert.js '+escape(obj2str), function(error, stdout, stderr){
    if(error) {
        console.error('error: ' + error);
        return;
    }
    console.log('stdout: ' + stdout);
    console.log('stderr: ' +  stderr);
});

console.log("f")