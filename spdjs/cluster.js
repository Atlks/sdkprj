var cluster = require('cluster');

var numCPUs = require('os').cpus().length; // 获取CPU的个数
console.log("numCPUs:"+ numCPUs)
if (cluster.isMaster) {
  console.log(`main主进程 ${process.pid} 正在运行`);
  for (var i = 0; i < 2; i++) {
    cluster.fork();
  }

  cluster.on('exit', function (worker, code, signal) {
    console.log('worker ' + worker.process.pid + ' died');
  });
} else {
  // sub process
  //appMain()
  console.log(`工作进程 ${process.pid} start  启动`);
  //require("./geneListPageFiles.js");
  console.log(`工作进程 ${process.pid} 已启动`);
 
}
console.log(`main主进程 ${process.pid} 正在运行 sec`);