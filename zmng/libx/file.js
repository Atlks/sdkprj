
global["file_exists"]=file_exists;
function file_exists(fil) {


    const fs = require('fs');

    const filePath = '/path/to/file';

    return (fs.existsSync(fil))


}