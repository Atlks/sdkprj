//  npm install mongodb
//  npm install mongodb

var MongoClient33 = require("mongodb").MongoClient;

(async () => {
    
    // Replace the uri string with your connection string.
    url = "mongodb://localhost:27017";

    MongoClient_conn = await MongoClient33.connect(url);
 

    myobj = { title: "Back to the Future" };

    await MongoClient_conn.db("db77").collection("col1_table1").insertOne(myobj);
    MongoClient_conn.close();

 

})();
