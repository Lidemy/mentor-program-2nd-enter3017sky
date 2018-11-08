
// function stars(n) {
//     var result = [];
//     for(var i = 1; i <= n; i++){
//         result.push(star(i)); // 塞 i 顆星星
//     }
//     return result;
// }

// // 準備一個印出 n 顆星星的函式
// function star(n) {
//     var result = '';
//     for(var i =0; i < n; i++){
//         result += '*';
//     }
//     return result;
// }
// console.log(star(3))



// while
function stars(n) {
    let i = 1, result = [];
    while (i <= n){
        result.push(star(i))
        i++ // 一直忘記打
    }
    return result
}

function star(n){
    let i = 0, result ='';
    while(i < n){
        result += '*';
        i++;
    }
    return result;
}




module.exports = stars;