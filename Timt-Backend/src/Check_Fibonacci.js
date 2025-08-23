function Check(number) {
    let a = 0;
    let b = 1;
    let sum = a+b;
    if(number==1 || number==0) {
        console.log(`${number} is in The Fibonacci Series.`);
        return;
    } else {
        while(sum<=number) {
            if(sum===number) {
                console.log(`${number} is in The Fibonacci Series.`);
                return;
            }
            a = b;
            b = sum;
            sum = a+b;
        }
    }
    console.log(`${number} is not in The Fibonacci Series.`);
}
module.exports = {Check};