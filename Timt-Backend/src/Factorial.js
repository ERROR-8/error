function Check(number) {
    console.log(`The Number is : ${number}`);
    if(number===0) {
        console.log(`Factorial of ${number} is 1.`);
        return;
    }
    let f = 1;
    for(let i=1; i<=number; i++) {
        f = f*i;
    }
    console.log(`Factorial of ${number} is ${f}.`);
}
module.exports = {Check};