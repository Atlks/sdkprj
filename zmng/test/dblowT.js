







(async ()=>{

    //await     import("@attilax/lowdbx")

     await     import("../lowdbx/lowdbX.js")

 //   console.log("ini_db_conn=>"+global["ini_db_conn"])

    let db;
    db= await  ini_db_conn(  __dirname+"/userColl4.json")

    var rcd={"u":123,"age":129}
    db.data.push(rcd)

// Finally write db.data content to file
    await db.write()


    console.log( db.data)

    // Sort the top five posts.


    // Load the full build.
    var _ = require('lodash');

    rzt=_.filter(db.data, { 'age': 129  })
    console.log(rzt)
    // db.data.get()
    //     .filter({age: 128})
    //     .sortBy('views')
    //     .take(2)
    //     .value()




})()