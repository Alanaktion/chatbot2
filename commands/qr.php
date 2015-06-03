<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $config;
	if (!empty($params[0])) {
		$param_str = implode(" ",$params);
		$response = Unirest::get("https://mutationevent-qr-code-generator.p.mashape.com/generate.php?content=" . urlencode($param_str), array("X-Mashape-Authorization" => $config["mashape_key"]));
		return $response->body->image_url;
	} else {
		return "Usage: #qr <text>";
	}
};
