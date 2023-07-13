
(async () => {
    logmdx = require('./jsdk/log.js');
    logger = logmdx.logger;
    logger.info("this is a info msg");
    mdx = require('./conn.js');
    connection = mdx.conn;

    query = require('./jsdk/mysql.js')

    const readline = require('readline');
    const fs = require('fs');

    file = 'D:\\prj\\spdJs\\insertDetail.sql'


    var lineReader = require('line-reader');

    //     const fs            = require('fs');
    // const readline      = require('readline');
    const StreamReader = require('async-stream-reader');

    const rl = readline.createInterface({
        input: fs.createReadStream(file)
    });
    const reader = new StreamReader(rl, {
        events: { data: 'line', end: 'close' },
    });


    var line;
    while (line = await reader.next()) {
        try {
            logger.info(line);
            
            let rzt = await query(connection, line)
            logger.info(rzt);

        } catch (e) {
            logger.error(e);
        }
    }


    // main().catch(error => console.log(error));




    // read all lines: 
    // await lineReader.eachLine(file,async function(line) { 

    //     try{
    //         console.log(line); 
    //         console.log('Line from file:', line);
    //         logger.info('Line from file:'+line);
    //         let rzt = await query(connection, line)
    //         logger.info(rzt);
    //     }catch(e)
    //     {
    //         logger.error(e);
    //     }

    // });


    // .then(function (err) { 
    //     if (err){
    //         logger.error(err);
    //         throw err; 
    //     }
    //     console.log("I'm done!!"); 

    // }); 

    // const rl = readline.createInterface({
    //     input: fs.createReadStream('D:\\prj\\spdJs\\insertDetail.sql')
    // });

    // rl.

    // rl.on('line', (line) => {
    //     console.log('Line from file:', line);
    //     let rzt = await query(connection, line)
    //     logger.info(rzt);
    // });

})();