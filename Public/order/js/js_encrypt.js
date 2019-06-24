// $(document).ready(function(){
// function js_decrypt(ciphertext){ 
//     var result;
//     var key='fenxiaoshisanyifenxiao'; 
//     key=format_key(key); 
//     var iv = 'fXyFiQCfgiKcyuVNCGoILQ==';
//     key = CryptoJS.enc.Utf8.parse(key);
//     iv = CryptoJS.enc.Base64.parse(iv);
//     plaintext = CryptoJS.AES.decrypt(ciphertext,key,{iv:iv,padding:CryptoJS.pad.ZeroPadding});
//     result = CryptoJS.enc.Utf8.stringify(plaintext);
//     return result; 
// }

// function js_encrypt(content){ 
//     var result;
//     var key='encryptionkey';     
//     key = format_key(key);
//     var iv = 'fXyFiQCfgiKcyuVNCGoILQ==';
//     key = CryptoJS.enc.Utf8.parse(key); 
//     iv = CryptoJS.enc.Base64.parse(iv);
//     var ciphertext = CryptoJS.AES.encrypt(content,key,{iv:iv,padding:CryptoJS.pad.ZeroPadding});
//     result = ciphertext.toString();
//     return result;
// }

// function format_key(key){
// 	while (key.length<16){
// 	key= key+'\u0000';
//     }
//     return key;
// }  
 

// })