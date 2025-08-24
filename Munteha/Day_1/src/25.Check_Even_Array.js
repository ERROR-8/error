function Check(a) {
    console.log(`Array : ${a}`);
    let p = 0;
    for(let n of a) {
        if(n%2 !== 0) {
            p = 1;
            break;
        }
    }
    if(p === 0) {
        console.log(`This Array contains all even numbers.`)
    } else {
        console.log(`This Array does not contains all even numbers.`)

    }
}
module.exports = {Check};