var log4js = require('log4js')
log4js.configure({ "appenders": [{ "type": "console" }], "replaceConsole": false })
logger = log4js.getLogger()
logger.setLevel("DEBUG")

var redis_host = '127.0.0.1', redis_port = 6379;
var redis = require("redis"), client = redis.createClient(redis_port, redis_host);

var io = require('socket.io').listen(4000);
io.set('transports', ['websocket' ,'flashsocket' ,'htmlfile' ,'xhr-polling' ,'polling']);

var users = [];
var sockets = {};

var map_key = "map:";
var getMapKey = function(broker_id) {
	return map_key + broker_id;
}

var chat_key = "chat:";
var getSocketKey = function(user_type, user_id, target_id) {
	return chat_key + ( user_type == 1 ? user_id + ":" + target_id : target_id + ":" + user_id );
}

var trim = function(str) {
	if(typeof(str) === 'string') {
		return str.replace(/(^\s+)|(\s+$)/g, "");
	}
	return str;
}

var contain = function(arr, val) {
	var i = arr.length;  
    while (i--) {  
        if (arr[i] === val) {  
            return true;  
        }  
    }  
    return false;
}

var remove = function(arr, val) {
	for(var i=0; i<arr.length; i++) {
		if(arr[i] == val) {
			arr.splice(i, 1);
			break;
		}
	}
}

var containKey = function(obj, key) {
	return obj.hasOwnProperty(key);
}

var removeKey = function(obj, key) {
	delete obj[key];
}

var updateStatus = function(broker_id, status) {
	client.lrange(getMapKey(broker_id), 0, -1, function(err, res) {
		logger.debug('update_status - users = ' + JSON.stringify(res) + ' length = ' + res.length)
		for(var i in res) {
			var user_id = res[i];
			if(contain(users, user_id) && containKey(sockets, user_id)) {
				logger.debug('update_status - user_id = ' + user_id + ' status = ' + status)
				sockets[user_id].emit('show-status', JSON.stringify({ status: status }));
			}
		}
	});
}

io.sockets.on('connection', function (socket) {
	socket.on('online',function(data){
		var data = JSON.parse(data);
		logger.debug('online - ' + JSON.stringify(data))
		
		var user_id = data.user_id;
		if(!contain(users, user_id)) {
			users.unshift(user_id);
		}
		logger.debug('online - user_id = ' + user_id + ' users - ' + JSON.stringify(users));
		
		sockets[user_id] = socket;
		logger.debug('online - sockets - keys = ' + JSON.stringify(Object.keys(sockets)) + ' length = ' + Object.keys(sockets).length);
		
		var user_type = data.user_type;
		if(user_type == 1) {
			var target_id = data.target_id;
			logger.debug('online - user_type = 1 - status - ' + contain(users, target_id));
			socket.emit('show-status', JSON.stringify({ status: contain(users, target_id) }));
		} else {
			logger.debug('online - user_type = 2 - status = true');
			updateStatus(user_id, true);
		}
	});
	
	socket.on('offline',function(data){
		socket.disconnect();
	});
	
	socket.on("disconnect", function() {
		setTimeout(function() {
			for(var user_id in sockets) {
				if(sockets[user_id] == socket) {
					logger.debug('disconnect - user_id = ' + user_id)
					updateStatus(user_id, false);
					
					remove(users, user_id);
					removeKey(sockets, user_id);
					break;
				}
			}
		}, 1000)
	});
	
	socket.on('send-message',function(data){
		var data = JSON.parse(data);
		var message = data.message
		if(undefined === message || null === message || "" === trim(message)) {
			return;
		}
		logger.debug('send-message - ' + JSON.stringify(data));
		
		var user_id = data.user_id;
		var target_id = data.target_id;
		var user_type = data.user_type;
		data['time'] = (new Date()).getTime();
		var json = JSON.stringify(data)
		client.lpush(getSocketKey(user_type, user_id, target_id), json, function(err, res){
			if(containKey(sockets, user_id)) {
				sockets[user_id].emit('receive-message', json);
			}
			if(containKey(sockets, target_id)) {
				sockets[target_id].emit('receive-message', json);
			}
		});
	});
	
	socket.on('show-history',function(data){
		logger.debug('show-history - ' + data);
		var data = JSON.parse(data);
		var user_id = data.user_id;
		var target_id = data.target_id;
		var user_type = data.user_type;
		client.lrange(getSocketKey(user_type, user_id, target_id), 0, 19, function(err, res) {
			if(containKey(sockets, user_id)) {
				sockets[user_id].emit('receive-history', JSON.stringify(res));
			}
		});
	});
});