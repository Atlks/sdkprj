const crypto = require('crypto');

function md5(str) {
    const md5sum = crypto.createHash('md5');
    md5sum.update(str);
    str = md5sum.digest('hex');
    return str;
}

console.log(md5("888888"))

// 21218cca77804d2ba1922c33e0151105