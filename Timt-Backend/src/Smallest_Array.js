function Check(a) {
    console.log(`Array : ${a}`);
    let min = a[0];
    for(let i=1; i<a.length; i++) {
        if(min>a[i]) {
            min = a[i];
        }
    }
    console.log(`Smallest number in the array is: ${min}`);
}
module.exports = {Check};