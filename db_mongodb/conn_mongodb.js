var MongoClient = require('mongodb').MongoClient;
var url = "mongodb://localhost:27017/runoob";

MongoClient.connect(url, function(err, db) {
    if (err) throw err;
    console.log("数据库已创建!");
   // db.close();

    var dbase = db.db("local");
    dbase.createCollection('site', function (err, res) {
        if (err) throw err;
        console.log("创建集合!");
     //   db.close();

        var myobj = { name: "菜鸟教程", url: "www.runoob" };
        dbase.collection("site").insertOne(myobj, function(err, res) {
            if (err) throw err;
            console.log("文档插入成功");
            //   db.close();
        });


    });




});