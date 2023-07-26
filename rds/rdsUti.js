 // driver ver 4.1 ,,,wb2
var redis = require("redis");

/******************
 *
 *  In version 4.1.0 we moved our subpackages from @node-redis to @redis. If you're just using npm install redis, you don't need to do anything—it'll upgrade automatically.
 * ** */
//var client = redis.createClient();
// var client = redis.createClient(6379, "127.0.0.1",{db:1});

(async () => {
  //   var client =await redis.createClient(6379, "127.0.0.1");
  client_rds = await conn("redis://:@localhost:6379");
  await client_rds.set("key", "value");

  console.log(await client_rds.get("key"));
   await client_rds.disconnect();  //must have,beir cant exit
})();

//ref  redis - npm
async function conn(url2) {
    const client = redis.createClient({
      url: url2,
    });
    client.on("error", (err) => {
      throw err;
    });
    await client.connect();
    return client;
  }
  
  console.log("11");