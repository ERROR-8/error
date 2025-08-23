function Check(a) {
    console.log(`Array : ${a}`);
    let b = [];
    for(i=0; i<a.length; i++) {
        b[i] = a[a.length - 1 - i];
    }
    console.log(`The Rreverse Array : ${b}`);
}
module.exports = {Check};