var redis_host = '127.0.0.1', redis_port = 6379;
var redis = require("redis"), client = redis.createClient(redis_port, redis_host);

var mysql = require("mysql");
var connection = mysql.createConnection({
	host: '127.0.0.1',
	user: 'root',
	password: 'soukecsk',
	database: 'funmall'
})

var io = require('socket.io').listen(4000);
io.set('transports', ['websocket' ,'flashsocket' ,'htmlfile' ,'xhr-polling' ,'polling']);

var users = [];
var sockets = [];
var chat_key = "chat:";

var getKey = function(user_type, user_id, target_id) {
	return chat_key + ( user_type == 1 ? user_id + ":" + target_id : target_id + ":" + user_id)
}

var trim = function(str) {
	if(typeof(str) === 'string') {
		return str.replace(/(^\s+)|(\s+$)/g, "");
	}
	return str;
}

Array.prototype.contains = function (obj) {  
    var i = this.length;  
    while (i--) {  
        if (this[i] === obj) {  
            return true;  
        }  
    }  
    return false;  
}

io.sockets.on('connection', function (socket) {
	socket.on('online',function(data){
		var data = JSON.parse(data);
		console.log('online - ' + JSON.stringify(data))
		
		var user_id = data.user_id;
		if(undefined === users[user_id] || null === users[user_id]) {
			users.unshift(user_id);
		}
		sockets[user_id] = socket;
		
		var user_type = data.user_type;
		if(user_type == 1) {
			console.log('online - status - ' + users.contains(data.target_id))
			socket.emit('show-status', JSON.stringify({ status: users.contains(data.target_id) }));
		}
	});
	
	socket.on('offline',function(data){
		socket.disconnect();
	});
	
	socket.on("disconnect", function() {
		setTimeout(function() {
			for(var index in sockets) {
				if(sockets[index] == socket) {
					delete users[index];
					delete sockets[index];
					break;
				}
			}
		}, 5000)
	});
	
	socket.on('list-user',function(data){
		var data = JSON.parse(data);
		var broker_id = data.broker_id;
		connection.connect();
		var sql = "SELECT DISTINCT open_id FROM wx_user WHERE broker_id = " + broker_id + " AND open_id IS NOT NULL AND open_id <> ''";
		connection.query(sql, function(err, rows, fields) {
		    if (err) throw err;
		    var online_users = []
		    for(var i in rows) {
				var open_id = rows[i].open_id
				if(users.contains(open_id)) {
					online_users.push(open_id);
				}
			}
		    socket.emit('show-user', JSON.stringify({ users: online_users }));
		});
		connection.end()
	});
	
	socket.on('send-message',function(data){
		var data = JSON.parse(data);
		var message = data.message
		if(undefined === message || null === message || "" === trim(message)) {
			return;
		}
		var user_id = data.user_id;
		var target_id = data.target_id;
		var user_type = data.user_type;
		data['time'] = (new Date()).getTime();
		var json = JSON.stringify(data)
		var socket_key = getKey(user_type, user_id, target_id);
		client.lpush(socket_key, json, function(err, res){
			if(undefined !== sockets[user_id] && null !== sockets[user_id]) {
				sockets[user_id].emit('receive-message', json);
			}
			if(undefined !== sockets[target_id] && null !== sockets[target_id]) {
				sockets[target_id].emit('receive-message', json);
			}
		});
	});
	
	socket.on('show-history',function(data){
		var data = JSON.parse(data);
		var user_id = data.user_id;
		var target_id = data.target_id;
		var user_type = data.user_type;
		var socket_key = getKey(user_type, user_id, target_id);
		client.lrange(socket_key, 0, 19, function(err, res) {
			if(undefined !== sockets[user_id] && null !== sockets[user_id]) {
				sockets[user_id].emit('receive-history', JSON.stringify(res));
			}
		});
	});
});