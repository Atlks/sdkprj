let set = new Set(); //或者 new Set(null);
set.add(2);set.add(3);set.add(4);set.add(3);set.add(3);
console.log(set);



catids='102,103,10,119,121,129,12,145,14,159,15,161,16,175,17,189,18,190,1,20,24,25,26,28,29,2,32,3,42,55,65,7,80,80,88,8,96,9'
arr=catids.split(',')
for (item of arr) {
    console.log(item)
}