var log4js = require('log4js')
log4js.configure({ "appenders": [{ "type": "console" }], "replaceConsole": false })
logger = log4js.getLogger()
logger.setLevel("INFO")

var redis_host = '127.0.0.1', redis_port = 6379;
var redis = require("redis"), client = redis.createClient(redis_port, redis_host);

var io = require('socket.io').listen(4000);
io.set('transports', ['websocket' ,'flashsocket' ,'htmlfile' ,'xhr-polling' ,'polling']);

var users = {};
var counts = {};
var sockets = {};

var map_key = "map:";
var chat_key = "chat:";

var getMapKey = function(broker_id) {
	return map_key + broker_id;
}

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

var updateType2Status = function(broker_id, status) {
	client.lrange(getMapKey(broker_id), 0, -1, function(err, res) {
		logger.debug('updateType2Status - users = ' + JSON.stringify(res) + ' length = ' + res.length)
		for(var i in res) {
			var user_id = res[i];
			if(containKey(users, user_id)) {
				logger.debug('updateType2Status - user_id = ' + user_id + ' status = ' + status);
				emit(user_id, 'show-status', { status: status });
				if(status) {
					emit(broker_id, 'show-status', { status: true, user_id: user_id });
				}
			}
		}
	});
}

var updateType1Status = function(broker_id, user_id, status) {
	logger.debug('updateType1Status - broker_id = ' + broker_id + ' user_id = ' + user_id + ' status = ' + status)
	if(containKey(users, broker_id)) {
		emit(broker_id, 'show-status', { status: status, user_id: user_id });
	}
	if(containKey(users, user_id)) {
		emit(user_id, 'show-status', { status: containKey(users, broker_id) });
	}
}

var getCount = function(user_id, target_id) {
	if(containKey(counts, user_id)) {
		if(containKey(counts[user_id], target_id)) {
			try {
				return parseInt(counts[user_id][target_id])
			} catch (e) {
				logger.error('Error in getCount - user_id=%s - target_id=%s ', user_id, target_id);
			}
		}
	}
	return 0;
}

var showHistory = function(data, index) {
	var data = JSON.parse(data);
	var user_id = data.user_id;
	var target_id = data.target_id;
	var user_type = data.user_type;
	client.lrange(getSocketKey(user_type, user_id, target_id), 0, index, function(err, res) {
		emit(user_id, 'receive-history', res);
	});
}

var emit = function(user_id, message, jsonData) {
	if(containKey(sockets, user_id)) {
		sockets[user_id].forEach(function(socket) {
			socket.emit(message, JSON.stringify(jsonData));
		});
	}
}

io.sockets.on('connection', function (socket) {
	socket.on('online',function(data){
		var data = JSON.parse(data);
		logger.info('online - ' + JSON.stringify(data))
		
		var user_id = data.user_id;
		var target_id = data.target_id;
		var user_type = data.user_type;
		
		if(!containKey(users, user_id)) {
			users[user_id] = {target_id: target_id, user_type: user_type}
		}
		if(!containKey(counts, user_id)) {
			counts[user_id] = {};
		}
		if(!containKey(sockets, user_id)) {
			sockets[user_id] = [];
			sockets[user_id].push(socket);
		}
//		if(!contain(sockets[user_id], socket)) {
//			sockets[user_id].push(socket);
//		}
		logger.debug('online - sockets - keys = ' + JSON.stringify(Object.keys(sockets)));
		
		if(user_type == 1) {
			updateType1Status(target_id, user_id, true);
		} else {
			updateType2Status(user_id, true);
		}
		var reset_flag = data.reset_flag;
		if(reset_flag) {
			logger.debug('online - reset_flag = true - count = 0');
			if(containKey(counts, user_id)) {
				counts[user_id][target_id] = 0;
			}
		} else {
			var count = getCount(user_id, target_id);
			logger.debug('online - reset_flag = false - count = ' + count);
			emit(user_id, 'receive-message', { count: count });
		}
	});
	
	socket.on("disconnect", function() {
		for(var user_id in sockets) {
			for(var index in sockets[user_id]) {
				if(sockets[user_id][index] == socket) {
					remove(sockets[user_id], socket);
					if(sockets[user_id].length === 0) {
						removeKey(sockets, user_id);
					}
					if(containKey(users, user_id)) {
						var user = users[user_id];
						logger.info('disconnect - user = ' + JSON.stringify(user));
						var user_type = user.user_type;
						var existed = containKey(sockets, user_id);
						if(user_type == 1) {
							var target_id = user.target_id
							updateType1Status(target_id, user_id, existed);
						} else {
							updateType2Status(user_id, existed);
						}
						if(!existed) {
							removeKey(users, user_id);
						}
					}
					break;
				}
			}
		}
	});
	
	socket.on('send-message',function(data){
		var data = JSON.parse(data);
		var message = data.message
		if(undefined === message || null === message || "" === trim(message)) {
			return;
		}
		logger.info('send-message - ' + JSON.stringify(data));
		var user_id = data.user_id;
		var target_id = data.target_id;
		var user_type = data.user_type;
		data['time'] = (new Date()).getTime();
		var json = JSON.stringify(data);
		client.lpush(getSocketKey(user_type, user_id, target_id), json, function(err, res){
			emit(user_id, 'receive-message', data);
			
			var count = getCount(target_id, user_id);
			count++;
			if(containKey(counts, target_id)) {
				counts[target_id][user_id] = count;
				data['count'] = count;
			}
			logger.debug('send-message - %s - %s', user_type, JSON.stringify(data));
			emit(target_id, 'receive-message', data);
		});
	});
	
	socket.on('show-history',function(data){
		logger.info('show-history - ' + data);
		showHistory(data, 19);
	});
	
	socket.on('show-all-history',function(data){
		logger.info('show-all-history - ' + data);
		showHistory(data, -1);
	});
	
	socket.on('zero-out',function(data){
		logger.info('zero-out - ' + data);
		var data = JSON.parse(data);
		var user_id = data.user_id;
		var target_id = data.target_id;
		if(containKey(counts, user_id)) {
			if(containKey(counts[user_id], target_id)) {
				counts[user_id][target_id] = 0;
			}
		}
	});
});

//var schedule = require('node-schedule');
//schedule.scheduleJob('* * * * *', function(){
//	for(var user_id in counts) {
//		for(var target_id in counts[user_id]) {
//			if(!containKey(users, target_id)) {
//				removeKey(counts[user_id], target_id);
//			}
//		}
//		if(counts[user_id].length === 0) {
//			removeKey(counts, user_id);
//		}
//	}
//});