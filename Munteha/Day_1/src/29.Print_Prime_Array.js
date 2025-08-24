function Check(a) {
    console.log(`Array : ${a}`);
    let b = [];
    let count = 0;
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
            b[count] = n;
            count++;
        }
    }
    if(count !== 0) {
        console.log(`Prime Numbers : ${b}`);
    } else {
        console.log(`This Array Does not Contain Any Prime Numbers.`)
    }
}
module.exports = {Check};