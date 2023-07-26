

function getintFrmlst(ch2, wrdlst) {
    arr = mmnc.split(",");
    var i = 0;
    for (var ch of arr) {
        console.log(ch)
        if (ch == ch2)
            return i;
        i++;
    }
}
function to7DgtHxStr(idx)
{
    hex=toHex(idx);
    frst4=to4binDgt(hex.charCodeAt(0));last4=to4binDgt(hex.charCodeAt(1));
    return left(frst4,3)+last4;
}
wrdlst = ['a', 'b']

mmnc = " a b a "
arr = mmnc.split(" ");
var seed;
for (var ch of arr) {
    console.log(ch)
    idx = getintFrmlst(ch, wrdlst);
    seed = seed + to7DgtHxStr(idx)
}
checkCode = last(seed, 4)
hashRzt = hash256(seed);
if (checkCode = left(hashRzt, 4))
    return ok

throw " chk err"