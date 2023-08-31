
const express = require('express')
const app = express()

// respond with "hello world" when a GET request is made to the homepage
app.get('/', (req, res) => {
    res.send('ok...')
})

app.get('/about', (req, res) => {
    res.send('about')
})

console.log(77)

var server = app.listen(80, function () {

    var host = server.address().address
    var port = server.address().port

    console.log("应用实例，访问地址为 http://%s:%s", host, port)

})

console.log(999999)