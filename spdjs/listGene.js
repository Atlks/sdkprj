

// var i=1,j=2
// var urltmp="https://cn.pornhub.com/video?c=${cate}&page=${page}";
// var urlact=urltmp.replace("${cate}",i).replace("${page}",j)
// console.log(urlact)
// throw "end"
var mysql      = require('mysql');
var connection = mysql.createConnection({
  host     : '182.16.50.115',
  user     : 'root',
  password : 'cjds1023123',
  database : 'dev_kok_movie'
});
 
connection.connect();
 
// connection.query('SELECT 1 + 1 AS solution', function (error, results, fields) {
//   if (error) throw error;
//   console.log('The solution is: ', results[0].solution);
// });

var obj={"类别":"un",类别id:5}
var obj2str=JSON.stringify(obj) ;
// connection.query('INSERT INTO 列表url库(data) VALUES(?)',[obj2str], (err, results) => {
//     if(err){
//         console.log(err);
//     }
//     console.log(results);
// })



var urltmp="https://cn.pornhub.com/video?c=${cate}&page=${page}";
for(i=1;i<200;i++)
{
    for(j=1;j<100;j++){
        var urlact=urltmp.replace("${cate}",i).replace("${page}",j)
        var obj={"类别":"un",类别id:i,page:j,url:urlact,site:"pornhub"}
        var obj2str=JSON.stringify(obj) ;
        connection.query('INSERT INTO 列表url库(data) VALUES(?)',[obj2str], (err, results) => {
            if(err){
                console.log(err);
            }
            console.log(results);
        })
    }
}
