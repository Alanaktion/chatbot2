<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $config;
	if(!empty($config["muc"]["enabled"])) {
		$muc_jid = $config["muc"]["room"] . '@' . $config["muc"]["server"] . '/' . $config["muc"]["nick"];
		$muc_options = array('no_history' => true);
		if(!empty($config["muc"]["password"])) {
			$muc_options["password"] = $config["muc"]["password"];
		}
		_info("Rejoining room {$muc_jid}...");
		$client->xeps['0045']->join_room($muc_jid, $muc_options);
		return "Rejoining room...";
	}
};
