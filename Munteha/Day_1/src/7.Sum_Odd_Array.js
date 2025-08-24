function Check(a) {
    console.log(`Array : ${a}`);
    let sum = 0;
    for(let n of a) {
        if(n%2 !== 0) {
            sum+=n;
        }
    }
    console.log(`Sum of Odd Numbers: ${sum}`);
}
module.exports = {Check};