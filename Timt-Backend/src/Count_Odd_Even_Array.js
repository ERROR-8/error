function Check(a) {
    console.log(`Array : ${a}`);
    let countOdd = 0;
    let countEven = 0;
    for(let n of a) {
        if(n%2 !== 0) {
            countOdd++;
        } else {
            countEven++;
        }
    }
    console.log(`Total Even Numbers: ${countEven}`);
    console.log(`Total Odd Numbers: ${countOdd}`);
}
module.exports = {Check};