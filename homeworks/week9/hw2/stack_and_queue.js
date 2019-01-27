var Stack = function() {
    if(!(this instanceof Stack)){
        return new Stack(name);
    }
    var item = [];
    // push 添加元素在堆疊的頂部
    Stack.prototype.push = function(element) {
        if(element) {
            item[item.length] = element;
        }
    }
    // pop 移除堆疊的頂部一個元素
    Stack.prototype.pop = function() {
        if(item.length === 0) {
            return 'Stack is empty!'
        }
        return item.splice(item[item.length-1], 1)
    }
    // peek 返回堆疊頂部的元素
    Stack.prototype.peek = function() {
        return item[item.length-1];
    }
    // 返回堆疊裡元素的數量
    Stack.prototype.size = function() {
        return item.length
    }
    // 確認堆疊是不是空的
    Stack.prototype.isEmpty = function() {
        return item.length === 0;
    }
    // 印出堆疊裡的元素
    Stack.prototype.print = function() {
        return console.log(item.toString())
    }
    // 清空堆疊
    Stack.prototype.clear = function() {
        item = []
    }
}


// 以下的方式會

var Queue = function() {
    if(!(this instanceof Queue)){
        return new Queue(name);
    }
    var item = [];
    this.push = function(element) {  // enqueue 入隊：向佇列的尾部添加一個元素
        if(element) {
            item[item.length] = element;
        }
    }
    this.pop = function() {    // dequeue 出隊： 移除堆疊的第一個元素
        if(item.length === 0) {
            return 'Queue is empty!'
        }
        // return item.splice(0, 1)
        return item.shift()
    }
    this.peek = function() {    // peek 返回堆疊頂部的元素
        return item[item.length-1];
    }
    this.size = function() {    // 返回堆疊裡元素的數量
        return item.length
    }
    this.isEmpty = function() {    // 確認堆疊是不是空的
        return item.length === 0;
    }
    this.print = function() {    // 印出堆疊裡的元素
        return console.log(item)
        // return console.log(item.toString())
    }
    this.clear = function() {    // 清空堆疊
        item = []
    }
}



function Data() {
    var item = []
    return {
        push: function(element) {
            item[item.length] = element;
        },
        pop: function() {    // dequeue 出隊： 移除堆疊的第一個元素
            if(item.length === 0) {
                return 'Queue is empty!'
            }
            // return item.splice(0, 1)
            return item.shift()
        },
        peek: function() {    // peek 返回堆疊頂部的元素
            return item[item.length-1];
        },
        size: function() {    // 返回堆疊裡元素的數量
            return item.length
        },
        isEmpty: function() {    // 確認堆疊是不是空的
            return item.length === 0;
        },
        print: function() {    // 印出堆疊裡的元素
            return console.log(item)
           // return console.log(item.toString())
        },
        clear: function() {    // 清空堆疊
            item = []
        }
    }
}








var s1 = new Stack()
var s2 = new Stack()
console.log('s1.size === s2.size: ', s1.size === s2.size)



var q1 = new Queue()
var q2 = new Queue()
// 會耗費很多記憶體
console.log('q1.size === q2.size:', q1.size === q2.size)


console.log(s1.push)
console.log(q1.push)


var data = Data()
var data2 = Data()

data.push(1)
data.push(2)
data.push(3)
data.pop()

// console.log(data.size())
// console.log(data2.size())
console.log(data.push)
console.log('data.push === data2.push: ', data.push === data2.push)


// var b = Dog('123')
// var d = Dog('456')
// b.sayHello()

// console.log(b.sayHello)
// console.log(b.sayHello === d.sayHello)
