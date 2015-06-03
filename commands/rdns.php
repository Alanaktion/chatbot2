<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $config;
	if (!empty($params[0])) {
		// Use gethostbyaddr() for local addresses
		if(preg_match("/^192|127|169\\./", $params[0])) {
			return gethostbyaddr($params[0]);
		} else {
			$response = Unirest::get("https://mark-sutuer-ip-utils.p.mashape.com/api.php?_method=resolveIp&address=" . urlencode($params[0]), array("X-Mashape-Authorization" => $config["mashape_key"]));
			return $response->body->host;
		}
	} else {
		return "Usage: #rdns <ip address>";
	}
};
