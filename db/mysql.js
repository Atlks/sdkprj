const mysql = require('mysql2');
const util = require('util');

const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'password',
    database: 'mydb'
});

const query = util.promisify(connection.query).bind(connection);

(async() => {
    try {
        const rows = await query('SELECT * FROM mytable');
        console.log(rows);
        connection.end();
    } catch (error) {
        console.log(error);
        connection.end();
    }
})();
在这个例子中， 我们首先创建了一个 mysql2 的连接对象 connection， 然后使用 util.promisify 方法将其 query 方法转换为 Promise。 接着， 我们使用 async / await 的方式来执行查询， 并使用 console.log 打印查询结果。 最后， 我们使用 connection.end() 方法关闭连接。

需要注意的是， 在使用 mysql2 的同步查询时， 必须将连接对象绑定到转换后的 query 方法上， 否则会导致 this 关键字指向错误。 这个例子中我们使用了 bind 方法来绑定连接对象。



const mysql = require('mysql2/promise');
const config = {
    host: 'localhost',
    user: 'root',
    password: 'password',
    database: 'mydb'
};

async function run() {
    try {
        const connection = await mysql.createConnection(config);
        const [rows, fields] = await connection.execute('SELECT * FROM mytable');
        console.log(rows);
        connection.end();
    } catch (error) {
        console.log(error);
    }
}

run();