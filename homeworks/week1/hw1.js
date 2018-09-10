/*hw1：印出星星
給定 n（1<=n<=30），依照規律印出正確圖形

n = 1
*

n = 3
*
*
*

*/
// for loop
function printStars(n) {
  var result = '*'
    for (var i = 1; i <= n; i++) {
    console.log(result)
  }
}
printStars(5)

// while loop
// function printStars(n){
//   var i = 1
//   var result = '*'
//   while(i <= n){
//     console.log(result)
//     i++
//   }
// }
// printStars(10)
