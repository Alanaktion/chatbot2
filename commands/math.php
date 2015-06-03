<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $config;
	if (!empty($params[0])) {
		$param_str = implode(" ",$params);
		$response = Unirest::get("https://alanaktion-qalc-v1.p.mashape.com/?q=" . urlencode($param_str), array("X-Mashape-Authorization" => $config["mashape_key"]));
		return $response->raw_body;
	} else {
		return "Usage: #math <expression>";
	}
};
