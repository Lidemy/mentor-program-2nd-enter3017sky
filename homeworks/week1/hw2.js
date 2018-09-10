//在 Javascript 對符號用 toUpperCase 它還是符號，所以不用管它

// function capitalize (input) {
//   var output = ''
//   for (var i = 0; i < input.length; i++) {
//     output += input[i].toUpperCase()
//   }
//   console.log(output)
// }

// capitalize('nike')

funciotn capitalize(input){
	var  output =''
var result = input.chatAt(0).toUpperCase()+input.slick(1)
return result
}
capitalize('nike')



function capitalize(str) {
	var first = str[0].toUpperCase
	return first + str.slice(1)
}

console.log( capitalize('nike'))

return str.replace(str[0],str[0].toUpperCase())