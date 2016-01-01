var log4js = require('log4js')
log4js.configure({ "appenders": [{ "type": "console" }], "replaceConsole": false })
logger = log4js.getLogger()
logger.setLevel("TRACE")

var redis_host = '127.0.0.1', redis_port = 6379;
var redis = require("redis"), client = redis.createClient(redis_port, redis_host);

var io = require('socket.io').listen(4000);
io.set('transports', ['websocket' ,'flashsocket' ,'htmlfile' ,'xhr-polling' ,'polling']);

var users = {};
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

var hasValue = function(val) {
	return undefined !== val && null !== val;
}

var updateBrokerStatus = function(broker_id, status) {
	client.lrange(getMapKey(broker_id), 0, -1, function(err, res) {
		logger.debug('updateBrokerStatus - users = ' + JSON.stringify(res) + ' length = ' + res.length)
		for(var i in res) {
			var user_id = res[i];
			if(containKey(users, user_id) && containKey(sockets, user_id)) {
				logger.debug('updateBrokerStatus - user_id = ' + user_id + ' status = ' + status);
				emit(user_id, 'show-status', { status: status });
				if(status) {
					emit(broker_id, 'show-status', { status: true, user_id: user_id });
				}
			}
		}
	});
}

var updateClientStatus = function(broker_id, user_id, status) {
	logger.debug('updateClientStatus - broker_id = ' + broker_id + ' user_id = ' + user_id + ' status = ' + status)
	if(containKey(users, broker_id) && containKey(sockets, broker_id)) {
		emit(broker_id, 'show-status', { status: status, user_id: user_id });
	}
	if(containKey(users, user_id) && containKey(sockets, user_id)) {
		emit(user_id, 'show-status', { status: containKey(users, broker_id) });
	}
}

var getNumber = function(user_id) {
	if(containKey(users, user_id)) {
		var user = users[user_id];
		if(containKey(user, 'count')) {
			try {
				return parseInt(user['count'])
			} catch (e) {}
		}
	}
	return 0;
}

var emit = function(user_id, message, jsonData) {
	sockets[user_id].forEach(function(socket) {
		socket.emit(message, JSON.stringify(jsonData));
	});
}

io.sockets.on('connection', function (socket) {
	socket.on('online',function(data){
		var data = JSON.parse(data);
		logger.debug('online - ' + JSON.stringify(data))
		
		var user_id = data.user_id;
		var target_id = data.target_id;
		var user_type = data.user_type;
		
		if(!containKey(users, user_id)) {
			users[user_id] = {target_id: target_id, user_type: user_type}
		}
		logger.trace('online - users - ' + JSON.stringify(users));
		
		if(!containKey(sockets, user_id)) {
			sockets[user_id] = [];
		}
		
		if(!contain(sockets[user_id], socket)) {
			sockets[user_id].push(socket);
		}
		
		logger.debug('online - sockets - keys = ' + JSON.stringify(Object.keys(sockets)));
		
		if(user_type == 1) {
			updateClientStatus(target_id, user_id, true);
			logger.debug('online - user_type = 1 - status = true');
			if(data.reset_count) {
				logger.debug('online - reset_count = true - count = 0');
				users[user_id]['count'] = 0;
			} else {
				var count = getNumber(user_id);
				logger.debug('online - reset_count = false - count = ' + count);
				emit(user_id, 'receive-message', { count: count });
			}
		} else {
			logger.debug('online - user_type = 2 - status = true');
			
			if(hasValue(target_id) && containKey(users, target_id)) {
				users[target_id]['count'] = 0;
			}
			updateBrokerStatus(user_id, true);
		}
	});
	
	socket.on('offline',function(data){
		socket.disconnect();
	});
	
	socket.on("disconnect", function() {
		setTimeout(function() {
			for(var user_id in sockets) {
				for(var index in sockets[user_id]) {
					if(sockets[user_id][index] == socket) {
						if(containKey(users, user_id)) {
							var user = users[user_id];
							logger.debug('disconnect - user = ' + JSON.stringify(user))
							var user_type = user.user_type
							if(user_type == 1) {
								var target_id = user.target_id
								updateClientStatus(target_id, user_id, false);
							} else {
								updateBrokerStatus(user_id, false);
							}
							removeKey(users, user_id);
						}
						removeKey(sockets[user_id], index);
						break;
					}
				}
				if(sockets[user_id].length === 0) {
					removeKey(sockets, user_id);
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
		
		var user_id = data.user_id;
		var target_id = data.target_id;
		var user_type = data.user_type;
		data['time'] = (new Date()).getTime();
		var json = JSON.stringify(data)
		client.lpush(getSocketKey(user_type, user_id, target_id), json, function(err, res){
			if(containKey(sockets, user_id)) {
				if(user_type == 1) {
					var count = getNumber(user_id);
					data.count = ++count;
					users[user_id]['count'] = data.count;
				}
				logger.debug('send-message - 1 - ' + JSON.stringify(data));
				emit(user_id, 'receive-message', data);
			}
			if(containKey(sockets, target_id)) {
				if(user_type == 2) {
					var count = getNumber(target_id);
					data.count = ++count;
					users[target_id]['count'] = data.count;
				}
				logger.debug('send-message - 2 - ' + JSON.stringify(data));
				emit(target_id, 'receive-message', data);
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
				emit(user_id, 'receive-history', res);
			}
		});
	});
});