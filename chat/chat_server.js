var redis_host = '127.0.0.1', redis_port = 6379;
var redis = require("redis"), client = redis.createClient(redis_port, redis_host);

var io = require('socket.io').listen(4000);
io.set('transports', ['websocket' ,'flashsocket' ,'htmlfile' ,'xhr-polling' ,'polling']);

var users = [];
var sockets = [];
var admin_id = "admin";
var chat_key = "chat:";

io.sockets.on('connection', function (socket) {
	
	socket.on('online',function(data){
		var data = JSON.parse(data);
		var user_id = data.user_id;
		if(!sockets[user_id]) {
			users.unshift(data.user_id);
		}
		sockets[user_id] = socket;
		socket.emit('list-user', JSON.stringify({ users: users }));
	});
	
	socket.on('send-message',function(data){
		var data = JSON.parse(data);
		var user_id = data.user_id;
		data['time'] = (new Date()).getTime();
		var json = JSON.stringify(data)
		client.lpush(chat_key + user_id, json, function(err, res){
			if(undefined !== sockets[user_id]) {
				sockets[user_id].emit('receive-message', json);
			}
		});
	});
	
	socket.on('show-history',function(data){
		var data = JSON.parse(data);
		var user_id = data.user_id;
		client.lrange(chat_key + user_id, -10, -1, function(err, res) {
			if(undefined !== sockets[user_id]) {
				sockets[user_id].emit('receive-history', JSON.stringify(res));
			}
		});
	});
	
	socket.on('offline',function(data){
		socket.disconnect();
	});
	
	socket.on("disconnect", function() {
		setTimeout(function() {
			for(var index in sockets) {
				if(sockets[index] == socket) {
					users.splice(users.indexOf(index),1);
					delete sockets[index];
					break;
				}
			}
		}, 5000)
	});
});