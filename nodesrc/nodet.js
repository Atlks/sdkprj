var _ = require('lodash')

var smartPerson = {
    'name': '戈德斯文',
    'gender': 'male'
},
smartTeam = ["戈德斯文", "杨海月", "柴硕", "师贝贝"];


console.log(_.includes(smartPerson, '戈德斯文'));
console.log(_.includes(smartTeam, '杨海月'));
console.log(_.includes(smartTeam, '杨海月',2));

 