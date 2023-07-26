//js获取公私钥、地址
//运行：node ethAddress.js
//npm install -g bip39
//npm install -g ethereum-hdwallet
//  C:\Users\tom\AppData\Roaming\npm\browserify.cmd mmnc2add2.js -o bundle_mmnc2add.js
//引入依赖
const bip39 = require('bip39')
const HDWallet = require('ethereum-hdwallet')

//生成助记词
const mnemonic = " glare pave fatal catch cake large mad exit any hood expose neither"
//bip39.generateMnemonic(128,null,bip39.wordlists.chiness_simplified)console.log('助记词' + mnemonic);

//通过随机助记词生成公私钥、地址
async function getAdress(mnemonic) {
    
    hdwallet= HDWallet.fromMnemonic(mnemonic)
   
 //   const hdwallet = HDWallet.fromSeed(seed)//通过seed获取hdWallet    
      key = hdwallet.derive("m/44'/60'/0'/0/0")//源于，得自。设置地址路径    
      //注意这个地址必须要44'60'0',必须单引号，没有回不一样
    console.log("PrivateKey = " + key.getPrivateKey().toString('hex'))//私钥    
    console.log("PublicKey = " + key.getPublicKey().toString('hex'))//公钥    
      EthAddress = '0x' + key.getAddress().toString('hex')//地址    
    console.log("Eth Address = " + EthAddress)
    document.writeln(EthAddress);
}

//通过同一个seed获取多个地址
async function getAdressFromSameSeed(mnemonic) {
    const seed = await bip39.mnemonicToSeed(mnemonic)//根据助记词生成seed    
    const hdwallet = HDWallet.fromSeed(seed)//通过seed获取hdWallet  

    for (var i = 0; i < 2; i++) {
        const key = hdwallet.derive("m/44' /60' /0/0" + i)//源于，得自。设置地址路径        
        console.log("========地址" + i + "===========")
        console.log("PrivateKey = " + key.getPrivateKey().toString('hex'))//私钥        
        console.log("PublicKey = " + key.getPublicKey().toString('hex'))//公钥        
        const EthAddress = '0x' + key.getAddress().toString('hex')//地址        
        console.log("Eth Address = " + EthAddress)
    }
}
//getAdress(mnemonic)
window.mmnc2ad=getAdress;
 //getAdressFromSameSeed(mnemonic)

/**
 * 
 * 
 * secp256k1 unavailable, reverting to browser version
node_modules/eccrypto/index.js:23
PrivateKey = 70df8aaa59969a2830791968de6666623f8bd05eda056534647387f8a949c146
nodesrc/mmnc2add2.js:18
PublicKey = f63e72a94928d26c7e81c538a409330dd4f548cd72dc9027fc87fc35a6ce3ea58c3f5049734146dd3da9f0daadc072fd58b9c4cfcea3a87f12e1f577d5a44057
nodesrc/mmnc2add2.js:19
Eth Address = 0x3584c87eb1ce571faef0c56b38a24b18d817214c
 */

