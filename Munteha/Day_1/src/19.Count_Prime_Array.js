function Check(a) {
    console.log(`Array : ${a}`);
    let countEven = 0;
    for (let n of a) {
        let p = 0;
        if (n <= 1) {
            continue;
        }
        for (let i = 2; i < n; i++) {
            if (n % i === 0) {
                p = 1;
                break;
            }
        }
        if(p === 0) {
            countEven++
        }
    }
    console.log(`Total prime numbers in the array: ${countEven}`);
}
module.exports = {Check};