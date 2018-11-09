// function alphaSwap(str) {
//     var result = ''; 
//     for( var i = 0; i < str.length; i ++){
//         // 如果字元等於字元轉成大寫，那就把字元轉成小寫放進輸出內容裡
//         if(str.charAt(i) == str.charAt(i).toUpperCase()){
//             result += str.charAt(i).toLowerCase();
//         } else {
//             result += str.charAt(i).toUpperCase();　
//         // 否則把字元轉成大寫放進輸出內容裡
//         }
//     }
//     return result // 打印輸出內容
// }


function alphaSwap(str) {
    let i = 0, result = '';
    while(i < str.length) {
        if(str.charAt(i) == str.charAt(i).toUpperCase()){
            result += str.charAt(i).toLowerCase()
        } else {
            result += str.charAt(i).toUpperCase()
        }
        i++
    }
    return result
}

module.exports = alphaSwap