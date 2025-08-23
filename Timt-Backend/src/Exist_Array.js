function Check(a, number) {
    console.log("Array : " + a);
    for(let i=0; i<a.length; i++) {
        if(number === a[i]) {
            console.log(`${number} Exist in The Array.`);
            return;
        }
    }
    console.log(`${number} Did Not Exist in The Array.`);
}
module.exports = {Check};