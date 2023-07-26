//  npm install mongodb
//var MongoClient = require("mongodb");
//import { MongoClient } from "mongodb";

 

exports.conn =async function (url) {
   
      var MongoClient_cls = require("mongodb").MongoClient;
      return  await   MongoClient_cls.connect(url );
     
  };

  
exports.insertOne = async function (conn_client, db, collectName, data) {
  await conn_client.db(db).collection(collectName).insertOne(data);
};
