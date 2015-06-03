<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $config;
	if(empty($params[0])) {
		return "Usage: #nick <nickname>";
	}

	$options = array('no_history' => true);
	if($config["muc"]["password"]) {
		$options["password"] = $config["muc"]["password"];
	}

	Bot::reply($msg, "Changing nickname...");
	$client->xeps['0045']->join_room($config["muc"]["room"] . '@' . $config["muc"]["server"] . '/' . implode(" ", $params), $options);
};
