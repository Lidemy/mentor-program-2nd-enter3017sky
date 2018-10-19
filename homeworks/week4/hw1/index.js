let firstNumber = null;
let secondNumber = null;
let operator = null;

for (let i = 0; i <= 9; i++) {
document.querySelector('.number' + i).addEventListener('click', () => {
    clickNumber(i)
    })
}

document.querySelector('.operator.plus').addEventListener('click', () => {
    handleOperator('+')
})
document.querySelector('.operator.minus').addEventListener('click', () => {
    handleOperator('-')
})
document.querySelector('.operator.equal').addEventListener('click', () => {
    handleOperator('=')
})
function clickNumber(num) {
    if (firstNumber === null) {
        appendResult(num)
    }
}
function handleOperator(op) {
    if (op === '='){
        secondNumber = Number(getResult());
        if(operator === '+'){
        getResult(firstNumber + secondNumber)
        } else if(operator === '-') {
            getResult(firstNumber - secondNumber)
        }
    } else {
            firstNumber = Number(getResult());
            setResult=('');
            operator = op;
        }
}
// 很多時候都會用到 result 這個東西，所以可以把它改成 function
function setResult(str) {
    document.querySelector('.result').innerText = str;
}
function appendResult(str) {
    // document.querySelector('.result').innerText = '';
    document.querySelector('.result').innerText += str;
}
function getResult(str) { //可以把上面的數字給拿出來
    return document.querySelector('.result').innerText
}
// eval
