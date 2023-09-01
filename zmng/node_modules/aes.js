var CryptoJS = require("crypto-js");

// 辅助函数
function md5(data) {
    return CryptoJS.MD5(data).toString();
}


// 传入key之前要调用，不然结果不对
function parseKey(key) {
    return CryptoJS.enc.Utf8.parse(key);
}

function isset(varname) {
    try {

        varname = varname.trim()
        rzt = typeof (eval(varname));
        return typeof (varname) != "undefined";
    } catch (e) {
        console.log(e.message);
        //  console_log(e);
        return false;
    }

}
//aes_mode_ECB=CryptoJS.mode.ECB;  //simple

function aes_mode_ECB()
{
    return CryptoJS.mode.ECB;;
}
//aes_mode_CBC=CryptoJS.mode.CBC;

function aes_mode_CBC()
{
    return CryptoJS.mode.CBC;;
}
if (isset("module"))
    module.exports = {aes_mode_CBC,aes_encrypt,aes_decrypt,md5,aes_mode_ECB}


// 加密过程
function aes_encrypt(mode, plainText, key, iv = null) {
    const uKey = parseKey(key);
    const uIv = parseKey(iv);

    return CryptoJS.AES.encrypt(plainText, uKey,
        {
            iv: uIv,
            mode: mode,
            padding: CryptoJS.pad.Pkcs7
        }
    ).toString();
}

// 解密过程
function aes_decrypt(mode, cipherText, key, iv = null) {
    const uKey = parseKey(key);
    const uIv = parseKey(iv);

    let bytes = CryptoJS.AES.decrypt(cipherText, uKey,
        {
            iv: uIv,
            mode: mode,
            padding: CryptoJS.pad.Pkcs7
        }
    );
    return bytes.toString(CryptoJS.enc.Utf8);
}


function  test301()
{
    // ECB 模式
    let cipherText = encrypt(CryptoJS.mode.ECB, data, md5Key);
    console.log(cipherText);
// 7J0VfbEYF0XdLnLuA1b4Fw==

    let plainText = decrypt(CryptoJS.mode.ECB, cipherText, md5Key);
    console.log(plainText);

// CBC 模式
    cipherText = encrypt(CryptoJS.mode.CBC, data, md5Key, iv);
    console.log(cipherText);
// sfH6iGxc01TkIaOUN77hQQ==

    plainText = decrypt(CryptoJS.mode.CBC, cipherText, md5Key, iv);
    console.log(plainText);

}


