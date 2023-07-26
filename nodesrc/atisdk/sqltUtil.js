

// enhance log and trycatch
exports.run = async function (sql,dbfile) {
    console.log(sql + " at::"+dbfile)
      sqlite3 = require("sqlite3");
      util = require("util");
    
    db = new sqlite3.Database(dbfile);
    db.run = util.promisify(db.run);
    db.all = util.promisify(db.all);
    try {
        await db.run(sql);
      }catch(err) {
        console.log(err);
      }

      console.log("   >>>>>> exe finish .."+sql)
}


 


// exports.run_prms = function run(sql, dbfile) {
//   return new Promise((resolve, reject) => {
//     db1350 = new sqlite3.Database(dbfile);
//     db1350.run(sql, [], (e, rsz) => {
//       if (e) reject(e);

//       //  console.log(111);
//       resolve(db1350);
//     });
//   });
// };

// // strong run trycatch,log add
// exports.run = async function (sql,dbfile) {
//   console.log(sql + " at::"+dbfile)
    
//   try {
//       await run_prms(sql,dbfile);
//     }catch(err) {
//       console.log(err);
//     }

//     console.log("   >>>>>> exe finish .."+sql)
// }