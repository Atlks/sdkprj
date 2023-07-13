// var log4js = require('log4js');
// log4js.configure({
//   appenders: [
//     {   
//       type: 'file', //文件输出
//       filename: 'logs/jslog.log', 
//       maxLogSize: 1024,
//       backups:3,
//       category: 'normal' 
//     }   
//   ]
// });
// var logger = log4js.getLogger('normalLoggerxxx');
// logger.setLevel('INFO');


// 基本使用

var log4js = require('log4js');

var logger = log4js.getLogger();

logger.level = 'debug';

logger.debug("Some debug messages");

// 第二种配置方式

log4js.configure({

    appenders: {

        ruleConsole: { type: 'console' },

        ruleFile: {

            type: 'dateFile',

            filename: 'logs/jslog_server-',

            pattern: 'yyyy-MM-dd.log',

            maxLogSize: 10 * 1000 * 1000,

            numBackups: 3,

            alwaysIncludePattern: true

        }

    },

    categories: {

        default: { appenders: ['ruleConsole', 'ruleFile'], level: 'info' }

    }

});



exports.logger = logger;