

var mysql      = require('mysql');
var connection = mysql.createConnection({
  host     : '182.16.50.115',
  user     : 'tom_akbar',
  password : '123456',
  database : 'dev_kok_sport'
});
 
connection.connect();


exports.conn = connection;