var redis_host = '127.0.0.1', redis_port = 6379;
var redis = require("redis"), client = redis.createClient(redis_port, redis_host);

var io = require('socket.io').listen(4000);
io.set('transports', ['websocket' ,'flashsocket' ,'htmlfile' ,'xhr-polling' ,'polling']);

var users = [];
var sockets = [];
var chat_key = "chat:";

var getSocketKey = function(b_id, u_id) {
	return b_id + ":" + u_id;
}

io.sockets.on('connection', function (socket) {
	socket.on('online',function(data){
		var data = JSON.parse(data);
		var b_id = data.b_id;
		var u_id = data.u_id;
		if(undefined === users[b_id] || null === users[b_id] ) {
			users[b_id] = [];
		}
		if(undefined === users[b_id][u_id] || null === users[b_id][u_id]) {
			users[b_id].unshift(u_id);
		}
		var socket_key = getSocketKey(b_id, u_id);
		if(undefined === sockets[socket_key] || null === sockets[socket_key]) {
			sockets[socket_key] = socket;
		}
	});
	
	socket.on('offline',function(data){
		socket.disconnect();
	});
	
	socket.on("disconnect", function() {
		setTimeout(function() {
			for(var index in sockets) {
				if(sockets[index] == socket) {
					var data = index.split(':');
					var b_id = data[0];
					var u_id = data[1];
					delete users[b_id][u_id];
					delete sockets[index];
					break;
				}
			}
		}, 5000)
	});
	
	socket.on('list-user',function(data){
		var data = JSON.parse(data);
		var b_id = data.b_id;
		socket.emit('show-user', JSON.stringify({ users: users[b_id] })); 
	});
	
	socket.on('send-message',function(data){
		var data = JSON.parse(data);
		var b_id = data.b_id;
		var u_id = data.u_id;
		data['time'] = (new Date()).getTime();
		var json = JSON.stringify(data)
		var socket_key = getSocketKey(b_id, u_id);
		client.lpush(chat_key + socket_key, json, function(err, res){
			if(undefined !== sockets[socket_key] && null !== sockets[socket_key]) {
				sockets[socket_key].emit('receive-message', json);
			}
		});
	});
	
	socket.on('show-history',function(data){
		var data = JSON.parse(data);
		var b_id = data.b_id;
		var u_id = data.u_id;
		var socket_key = getSocketKey(b_id, u_id);
		client.lrange(chat_key + socket_key, -10, -1, function(err, res) {
			if(undefined !== sockets[socket_key] && null !== sockets[socket_key]) {
				sockets[socket_key].emit('receive-history', JSON.stringify(res));
			}
		});
	});
});