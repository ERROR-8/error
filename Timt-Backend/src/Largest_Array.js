function Check(a) {
    console.log(`Array : ${a}`);
    let max = a[0];
    for(let i=1; i<a.length; i++) {
        if(max<a[i]) {
            max = a[i];
        }
    }
    console.log(`Largest number in the array is: ${max}`);
}
module.exports = {Check};