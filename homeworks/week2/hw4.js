function isPalindromes(str) {
    // 如果 str === 經過反轉的reverseStr , return true
    if(str === reverse(str))return true;
    return false;
}

function reverse(str) {
    var reverseStr = '';
    for (var i = str.length - 1; i >= 0; i--) {
      reverseStr += str[i];
    }
    return reverseStr;
}

module.exports = isPalindromes