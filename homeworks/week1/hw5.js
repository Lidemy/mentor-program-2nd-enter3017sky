/*
hw5：自己的函式自己寫
其實仔細思考的話，你會發現那些陣列內建的函式你其實都寫得出來，因此這一題就是要讓你自己動手實作那些函式！
我們要實作的函式有兩個：join 以及 repeat。
join 會接收兩個參數：一個陣列跟一個字串，會在陣列的每個元素中間插入一個字串，最後合起來。
repeat 的話就是輸出重複 n 次之後的字串。
join([1, 2, 3], '') => 123
join(["a", "b", "c"], "!") => a!b!c
join(["a", 1, "b", 2, "c", 3], ',') => a,1,b,2,c,3
repeat('a', 5) => aaaaa
repeat('yoyo', 2) => yoyoyoyo
*/

function join (str, concatStr) {
  var result = str[0]
  for (var i = 1; i < str.length; i++) {
    result = result + concatStr + str[i]
  }
  return result
}
console.log(join([1, 2, 3], ' '))
console.log(join(['a', 'b', 'c'], '!'))
console.log(join(['a', 1, 'b', 2, 'c', 3], '!~!'))

// // hw5-2 forloop
function repeat (str, times) {
  var result = ''
  for (var i = 0; i < times; i++) {
    result += str
  }
  return result
}
console.log(repeat('a', 5))
console.log(repeat('yoyoyo', 2))

// hw5-2 while loop
function repeatWhile (str, times) {
  var result = ''
  var i = 0
  while (i < times) {
    result += str
    i++
  }
  return result
}
console.log(repeatWhile('a', 5))
console.log(repeat('nikeeee', 2))
