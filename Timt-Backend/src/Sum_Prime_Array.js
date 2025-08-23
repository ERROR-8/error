function Check(a) {
    console.log(`Array : ${a}`);
    let sum = 0;
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
            sum += n;
        }
    }
    console.log(`Sum of prime numbers in the array: ${sum}`);
}
module.exports = {Check};