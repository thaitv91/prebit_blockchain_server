var fs = require('fs');
var https = require('https');
var options = {
  key: fs.readFileSync('key.pem'),
  cert: fs.readFileSync('cert.pem')
};

var app = require('express')();
//var server = require('http').Server(app);
var server = https.createServer(options, app);
var io = require('socket.io')(server);
var redis = require('redis');




server.listen(8890);

io.on('connection', function (socket) {

    console.log("new client connected");

    var redisClient = redis.createClient();

    redisClient.subscribe('notification');

    redisClient.on("message", function(channel, message) {
        console.log("New message: " + message + ". In channel: " + channel);
        socket.emit(channel, message);
    });

    socket.on('disconnect', function() {
        //socket.socket.reconnect();
        redisClient.quit();
    });

});