function reverse (str) {
  var reverseStr = ''
  // 從最後一個 str.length-1 ， i >= 0 跑到第零個
  for (var i = str.length - 1; i >= 0; i--) {
    reverseStr += str[i]
  }
  console.log(reverseStr)
}
reverse('yoyoyo')

reverse('1abc2')
