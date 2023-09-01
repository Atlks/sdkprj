import {join, dirname} from 'path'
import {Low, LowSync} from 'lowdb'
import {fileURLToPath} from 'url'
import {JSONFile,JSONFileSync} from 'lowdb/node'

const __dirname = dirname(fileURLToPath(import.meta.url));

// Use JSON file for storage
const file = join(__dirname, '../coll_user.json')
console.log('data path --->', file)
const adapter = new JSONFile(file)

const defaultData = []
const db = new Low(adapter, defaultData)

//export default db

async function ini_db_conn(file) {


    const defaultData = []
  //  file = join(__dirname, file);
    let jsonFile = new JSONFileSync (file);
    let db = new Low(
        jsonFile, defaultData);
    await db.read()
  //  var rcd = {"u": 123, "age": 19}
   // db.data.push(rcd)
    return db;

}


  function pdo_conn(file) {


    const defaultData = []
    //  file = join(__dirname, file);
    let jsonFile = new JSONFileSync (file);
    let db = new LowSync(
        jsonFile, defaultData);
      db.read()
    //  var rcd = {"u": 123, "age": 19}
    // db.data.push(rcd)
    return db;

}
global["pdo_conn"] = pdo_conn

global["pdo_exec_query"] = pdo_exec_query
function pdo_exec_query( dbfile) {
    //  alert("上分成功")
    // await import("../lowdbx/lowdbX.js")

    //   console.log("ini_db_conn=>"+global["ini_db_conn"])

    let db;

    db =pdo_conn(dbfile)
    db.read()

    return db.data;
}




async function pdo_exec_insert( rcd,dbfile) {
    //  alert("上分成功")
   // await import("../lowdbx/lowdbX.js")

    //   console.log("ini_db_conn=>"+global["ini_db_conn"])

    let db;

    db = await ini_db_conn(dbfile)

    db.data.push(rcd)

// Finally write db.data content to file
    await db.write()
    return db;
}

global["pdo_exec_insert"] = pdo_exec_insert

global["ini_db_conn"] = ini_db_conn

export {ini_db_conn};
// Read data from JSON file, this will set db.data content
// If JSON file doesn't exist, defaultData is used instead
// await db.read()
//
// var rcd={"u":123,"age":19}
// db.data.push(rcd)
//
// // Finally write db.data content to file
// await db.write()


//  cd zmng/lowdbx
//  npm publish --access=public