<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if(empty($params[0])) {
		return "Usage: #join <room> [room_server] [nick] [password]";
	}

	$config = Bot::config();

	$room = $params[0];
	$server = !empty($params[1]) ? $params[1] : $config["muc"]["server"];
	$nick = !empty($params[2]) ? $params[2] : $config["muc"]["nick"];
	$password = !empty($params[3]) ? $params[3] : false;

	$client->xep['0045']->join_room(
		$room . '@' . $server . '/' . $nick,
		array('no_history' => true) + $password ? array('password' => $password) : array()
	);
	return "Joining room {$room}@{$room_server} as {$nick}";
};
