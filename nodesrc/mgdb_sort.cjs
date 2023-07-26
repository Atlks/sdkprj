//  npm install mongodb
//  npm install mongodb

var MongoClient33 = require("mongodb").MongoClient;

(async () => {
  // Replace the uri string with your connection string.
  url = "mongodb://localhost:27017";

  MongoClient_conn = await MongoClient33.connect(url);
  const startIdx = 888888;
  var finish=startIdx + 8;
 
      await MongoClient_conn.db("imapi").collection("userx").find();
    
  MongoClient_conn.close();
})();
