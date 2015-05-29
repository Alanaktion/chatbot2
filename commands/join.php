<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $config;

	if(empty($params[0])) {
		return "Usage: #join <room> [room_server] [nick] [password]";
	}

	$server = !empty($params[1]) ? $params[1] : $config["muc"]["server"];
	$nick = !empty($params[2]) ? $params[2] : $config["muc"]["nick"];

	$client->xep['0045']->join_room(
		$params[0] . '@' . $server . '/' . $nick,
		array('no_history' => true) + !empty($params[3]) ? array('password' => $params[3]) : array()
	);
	return "Joining room {$room}@{$room_server} as {$nick}";
};
