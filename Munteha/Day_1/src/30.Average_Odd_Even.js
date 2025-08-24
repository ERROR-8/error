function Check(a) {
    console.log(`Array : ${a}`);
    let even = 0; 
    let odd = 0;
    let evenCount = 0;
    let oddCount = 0;
    for (let num of a) {
        if (num % 2 === 0) {
            even += num;
            evenCount++;
        } else {
            odd += num;
            oddCount++;
        }
    }
    let evenAvg = 0;
    if (evenCount > 0) {
        evenAvg = even / evenCount;
    }
    let oddAvg = 0;
    if (oddCount > 0) {
        oddAvg = odd / oddCount;
    }
    console.log(`Average of even numbers: ${evenAvg}`);
    console.log(`Average of odd numbers: ${oddAvg}`);
}
module.exports = {Check};