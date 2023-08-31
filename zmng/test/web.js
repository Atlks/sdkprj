/////------------- stgart web

const app_web = require('express')()


app_web.listen(8000)





app_web.get('/fun1', (req, res) => {
    res.send('fun1...')
})



































// app_web.get('/fun2', (req, res) => {
//     res.send('fun2...')
// })
//
//
// app_web.get('/', (req, res) => {
//     res.send('okkk')
// })