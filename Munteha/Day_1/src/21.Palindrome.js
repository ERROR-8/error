function Check(str) {
    console.log(`The String is : ${str}`);
    const strCopy = str.toLowerCase();
    const reverseStr = strCopy.split('').reverse().join('');
    if(strCopy === reverseStr) {
        console.log(`${str} is a Palindrome.`);
        return;
    }
    console.log(`${str} is not a Palindrome.`);
}
module.exports = {Check};