

function stars(n) {
    var result = [];
    for(var i = 1; i <= n; i++){
        result.push(star(i)); // 塞 i 顆星星
    }
    return result;
}

//準備一個印出 n 顆星星的函式
function star(n) {
    var result = '';
    for(var i =0; i < n; i++){
        result += '*';
    }
    return result;
}
// console.log(star(3))

module.exports = stars;