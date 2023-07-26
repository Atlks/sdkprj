//  npm install mongodb
//  npm install mongodb

var MongoClient33 = require("mongodb").MongoClient;

(async () => {
  // Replace the uri string with your connection string.
  url = "mongodb://localhost:27017";

  MongoClient_conn = await MongoClient33.connect(url);
  const startIdx = 888888;
  var finish=startIdx + 8;
  for (var i = startIdx; i++; i <finish ) {
    if(i>finish) 
    break;
    myobj = { _id: i, nickname: "测试" + i,createTime:Date.now() };
    try {
      await MongoClient_conn.db("imapi").collection("user").insertOne(myobj);
    } catch (error) {
      console.log(error);
    }
    console.log(myobj);
  }
  MongoClient_conn.close();
})();
