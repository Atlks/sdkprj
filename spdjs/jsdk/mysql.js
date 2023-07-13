const mysql = require('mysql')
 

// 接收一个sql语句 以及所需的values
// 这里接收第二参数values的原因是可以使用mysql的占位符 '?'
// 比如 query(`select * from my_database where id = ?`, [1])

let query = function(connection, sql, values ) {
  // 返回一个 Promise
  return new Promise(( resolve, reject ) => {
 
        connection.query(sql, values, ( err, rows) => {

          if ( err ) {
            reject( err )
          } else {
            resolve( rows )
          }
          // 结束会话
        //  connection.release()
        })
      });
    };
 
module.exports =  query