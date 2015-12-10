var redis_host = '127.0.0.1', redis_port = 6379;
var redis = require("redis"), client = redis.createClient(redis_port, redis_host);

var io = require('socket.io').listen(4000);
io.set('log level', 1);
io.set('transports', ['websocket' ,'flashsocket' ,'htmlfile' ,'xhr-polling' ,'jsonp-polling']);

var online_user_chat_key = "chat:";
var online_user_list_key = "user:list";

var sockets = [];
var user_info_hash = {};
var socket_user_hash = {};

io.sockets.on('connection', function (socket) {
	//console.log("sockets => ", sockets);
	
	socket.on('add-user', function(data) {
		var user = JSON.parse(data).user;
		var id_user = user.id;
		user_info_hash[id_user] = user;
		socket_user_hash[socket.id] = id_user;
		client.sadd(online_user_list_key, id_user, function(err, res){
			update_user_list(id_user, socket);
		});
	});
	
	socket.on('send-message', function(data){
		var msg = JSON.parse(data);
		var id_target = msg.id_target;
		var id_user = msg.id_user;
		var message = msg.message;
		var date_string = msg.date;
		var id_chat = [id_user, id_target].sort().join("_");
		var json = JSON.stringify({ 'id_user': id_user, 'id_target': id_target,  'message': message, 'date': date_string });
		client.lpush(online_user_chat_key + id_chat, json, function(err, res){
			if (undefined != sockets[id_chat]) {
				for (var id_user in sockets[id_chat]){
					for (var socket_id in sockets[id_chat][id_user]) {
						sockets[id_chat][id_user][socket_id].emit('receive-message', json);
					}
	            }
			}
		});
	});

	socket.on("disconnect", function() {
		var user_id = socket_user_hash[socket.id];
		if(undefined != user_id) {
			client.srem(online_user_list_key, user_id, function(){
				update_user_list(user_id, socket);
			});
			for(var id_chat in sockets) {
				for(var id_user in sockets[id_chat]) {
					if(id_user == user_id) {
						delete sockets[id_chat][id_user];
					}
				}
			}
		}
	});
	
	socket.on("add-socket", function(data) {
		var msg = JSON.parse(data);
		var id_target = msg.id_target;
		var id_user = msg.id_user;
		store_socket(id_user, id_target, socket);
	});
});

function update_user_list(id_user, socket) {
	client.smembers(online_user_list_key, function(error, users) {
		if(users.length > 0) {
			var user_info = {};
			for(var i in users) {
				var user_id = users[i];
				if(undefined != user_info_hash[user_id]) {
					user_info[user_id] = user_info_hash[user_id];
				}
			}
			show_online_users(user_info, id_user, socket);
		}
	});
}

function show_online_users(user_info, id_user, socket) {
	var reply = JSON.stringify({ id_user: id_user, user_info: user_info });
	io.sockets.emit('show-online', reply);
	for(var id_target in user_info) {
		store_socket(id_user, id_target, socket);
	}
}

function store_socket(id_user, id_target, socket) {
	if(id_user != id_target) {
		var id_chat = [id_user, id_target].sort().join("_");
		if (undefined == sockets[id_chat]) {
			sockets[id_chat] = {};
		}
		if (undefined == sockets[id_chat][id_user]) {
			sockets[id_chat][id_user] = {}
		}
		sockets[id_chat][id_user][socket.id] = socket;
	}
}

//var schedule = require('node-schedule');
//var job = schedule.scheduleJob('* * * * *', function(){
//    console.log("schedule => " + sockets);
//});