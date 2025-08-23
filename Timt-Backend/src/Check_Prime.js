function Check(number) {
    console.log(`The Number is : ${number}`);
    if (number <= 1) {
        console.log(`${number} is not a Prime Number.`);
        return;
    }
    for(i=2;i<number;i++) {
        if(number%i === 0) {
            console.log(`${number} is not a Prime Number.`);
            return;
        }
    }
    console.log(`${number} is a Prime Number.`);
}
module.exports = {Check};