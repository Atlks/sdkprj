
require("fp_ati1990")

require("esm-hook");
const {JSONFile} = require("lowdb/node");
const pkg= require("lowdb") ;

const  {Low} = pkg;
const chalk = require('chalk').default
const low = require('lowdb').default
//const FileSync = require('lowdb/adapters/FileSync').default


const adapter = new JSONFile("db301.json")
//const adapter = new FileSync('db301.json')
console.log(123)
console_log(123)
console_log(123+adapter)
//  const db = new Low(adapter)
//
// db.data =[];

let log1;
log1={"u":"acc1","amt":1,"type":"上分","time":curDateTime()}

// db.data.push(log1)
//  // db.write()



async function  main(){




  await import("../lowdbx/lowdbX.js")
  let dbfile = __dirname+"/../scoreLogColl.json";

  let data;
  data= pdo_exec_query(dbfile)

  var _ = require('lodash');
  rzt=_.filter(data, { 'uname': "u1"  })
  console.log(rzt)
 // console.log(data)





}

 // (async () => )();
main()
