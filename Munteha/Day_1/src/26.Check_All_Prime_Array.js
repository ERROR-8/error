function Check(a) {
    console.log(`Array : ${a}`);
    let check = 0;
    for (let n of a) {
        let p = 0;
        if (n <= 1) {
            console.log(`This Array does not contains all Prime Numbers.`);
            return;
        }
        for (let i = 2; i < n; i++) {
            if (n % i === 0) {
                console.log(`This Array does not contains all Prime Numbers.`);
                return;
            }
        }
    }
    console.log(`This Array contains all Prime Numbers.`);
}
module.exports = {Check};