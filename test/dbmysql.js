// 加载 mysql module
var sys = require("sys");
var mysql = require("mysql");

var dataBaseLinkInfo = {

    "host": '127.0.0.1',

    "database": 'mysql',

    "port": 3306,

    "user": 'root',

    "password": ""

}

var connection = mysql.createConnection(dataBaseLinkInfo);

connection.connect();

connection.query('SELECT * FROM  help_topic limit 10', function selectCb(err, rows, fields) {

    if (err) {

        throw err;

    }

    console.log(rows);
    var sys = require("sys");
    console.log("finish qury")
    //   sys.puts("---------------------------------------Hello bbbb");

    //   console.log(fields);

})

connection.end();