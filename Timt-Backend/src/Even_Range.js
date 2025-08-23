function Check() {
    console.log("Even Number Between 1 to 50 are : ");
    let number = 1;
    while(number<=50) {
        if(number%2 === 0) {
            console.log(number);
        } 
        number++;
    }
}
module.exports = {Check};