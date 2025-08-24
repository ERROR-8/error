function Check(a) {
    console.log(`Array : ${a}`);
    let even = [];
    let odd = [];
    let e = 0;
    let o = 0;
    for(let i=0; i<a.length; i++) {
        if(a[i]%2 === 0) {
            even[e] = a[i];
            e++;
        } else {
            odd[o] = a[i];
            o++
        }
    }
    console.log(`Even Numbers : ${even}`);
    console.log(`Odd Numbers : ${odd}`);
}
module.exports = {Check};