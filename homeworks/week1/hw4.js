// hw4 印出因數

// function printFactor (n) {
//   for (var i = 1; i <= n; i++) {
//     if (n % i === 0) { // 假如n對i取餘數等於0的話,印出i
//       console.log(i)
//     }
//   }
// }

// printFactor(10)
// console.log(' ')
// printFactor(7)

function printFactor (n) {
  for (var i = 1; i <= n; i++) {
    if (n % i === 0) {
 continue
    }
    console.log(i)
  }
}
printFactor(10)
