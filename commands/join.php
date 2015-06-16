<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $config;

	if(empty($params[0])) {
		return "Usage: #join <room> [room_server] [nick] [password]";
	}

	$room = $params[0];
	$server = !empty($params[1]) ? $params[1] : $config["muc"]["server"];
	$nick = !empty($params[2]) ? $params[2] : $config["muc"]["nick"];
	$jid = $room . '@' . $server . '/' . $nick;

	$options = array('no_history' => true);
	if(!empty($params[3])) {
		$options['password'] = $params[3];
	}

	$client->xeps['0045']->join_room($jid, $options);
	return "Joining room {$room}@{$server} as {$nick}";
};
