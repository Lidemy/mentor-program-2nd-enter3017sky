function reverse (str) {
  var reverseStr = ''
  // 從最後一個 str.length-1 ，跑到第零個 i >= 0
  for (var i = str.length - 1; i >= 0; i--) {
    reverseStr += str[i]
  }
  return reverseStr
}

console.log(reverse('yoyoyo'))
console.log(reverse('1abc2'))
console.log(reverse('nikeee'))
