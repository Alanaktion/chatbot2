<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if(empty($params[0])) {
		return "Usage: #nick <nickname>";
	}

	$config = Bot::config();
	$client->xep['0045']->join_room(
		$config["muc"]["room"] . '@' . $config["muc"]["server"] . '/' . $params[0],
		array('no_history' => true) + $config["muc"]["password"] ? array('password' => $config["muc"]["password"]) : array()
	);
	return "Changing nickname...";
};
