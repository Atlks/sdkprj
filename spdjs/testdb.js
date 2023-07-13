//  testdb

mdx = require('./conn.js');
connection = mdx.conn;

var obj2str='{}';
connection.query('INSERT INTO 抓取数据记录(数据) VALUES(?)', [obj2str], (err, results) => {
    if (err) {
        console.log(err);
    }
    console.log(results);
})