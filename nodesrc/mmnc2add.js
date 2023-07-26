let lightwallet = require("eth-lightwallet");
//cant install modules

hdPathString = "m/44'/60'/0'/0"; ///eth
// hdPathString = 'm/0/0/0';
seedPhrase_mmnc =
  "glare pave fatal catch cake large mad exit any hood expose neither";
lightwallet.keystore.createVault(
  {
    password: "",
    seedPhrase: seedPhrase_mmnc, // Optionally provide a 12-word seed phrase    // 导入 时 这里 可以传入 助记词
    // salt: fixture.salt,     // Optionally provide a salt.
    // A unique salt will be generated otherwise.
    hdPathString: hdPathString, // Optional custom HD Path String
  },
  function (err, ks) {
    // Some methods will require providing the `pwDerivedKey`,
    // Allowing you to only decrypt private keys on an as-needed basis.
    // You can generate that value with this convenient method:

    ks.keyFromPassword("", function (err, pwDerivedKey) {
      if (err) throw err;

      // generate five new address/private key pairs
      // the corresponding private keys are also encrypted

      ks.generateNewAddress(pwDerivedKey, 1);
      address = ks.getAddresses()[0];
      console.log("0x" + address); // 地址
      privateKey = ks.exportPrivateKey(address, pwDerivedKey);
      console.log("0x" + privateKey); // 私钥
      randomSeed = ks.getSeed(pwDerivedKey); // 助记词
      console.log(randomSeed); // 助记词
      // Now set ks as transaction_signer in the hooked web3 provider
      // and you can start using web3 using the keys/addresses in ks!
    });
  }
);
