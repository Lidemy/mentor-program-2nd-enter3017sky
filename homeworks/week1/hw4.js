/* hw4 印出因數
給定一個數字 n，因數就是所以小於等於 n 又可以被 n 整除的數。

// */
function printFactor (n) {
  for (var i = 1; i <= n; i++) {
    if (n % i === 0) { // 假如n對i取餘數等於0的話,印出i
      console.log(i)
    }
  }
}

printFactor(10)
console.log(' ')
printFactor(7)
