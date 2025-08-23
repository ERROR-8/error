function Check(a) {
    console.log(`Array : ${a}`);
    if (a.length === 0) {
        console.log("Array is empty.");
        return;
    }
    let max = a[0];
    let min = a[0];
    for (let i = 1; i < a.length; i++) {
        if (max < a[i]) {
            max = a[i];
        }
        if (min > a[i]) {
            min = a[i];
        }
    }
    console.log(`Max : ${max}`);
    console.log(`Min : ${min}`);
}
module.exports = { Check };