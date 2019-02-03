
const findMin = arr => {
    let min = arr[0]
    for(let i = 0; i < arr.length; i++) {
        if(min > arr[i]) {
            min = arr[i]
        }
    }
    return min
}

const findSmallCount = (arr, n) => {
    var count = 0
    for(let i = 0; i < arr.length; i++) {
        if(arr[i] < n) {
            count++
        }
        return count
    }
}


const add = (a, b) => a + b

export default add

// export default function add(a, b) {
//     return a + b
// }

export { findMin, findSmallCount }