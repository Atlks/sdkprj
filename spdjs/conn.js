

var mysql      = require('mysql');
var connection = mysql.createConnection({
  host     : '182.16.50.115',
  user     : 'root',
  password : 'cjds1023123',
  database : 'dev_kok_movie'
});
 
connection.connect();


exports.conn = connection;