 var mod1 = require( "./atisdk/mongodb_sync");

//import mod1 from "atisdk/mongodb_sync"

(async () => {

 
    conn_client = await  mod1.conn("mongodb://localhost:27017/testdb");
    console.log(111);
    data = { title: "Back to the Future" };
    await  mod1.insertOne(conn_client, "db129", "col2", data);

    console.log(222);

   
        //must need wait some seceond to wait conn write to  mongodb svr
        conn_client.close();  //must need,beirs node cant exit
 
  

})();

