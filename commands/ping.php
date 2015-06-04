<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if (!empty($params[0])) {
		$response = json_decode(BotHttp::GET("http://phpizza.com/~alan/ping.php?host=" . urlencode($params[0])));
		if($response->online) {
			return "Online - " . $response->ping;
		} else {
			return "Unable to connect to host.";
		}
	} else {
		return "Usage: #ping <host>";
	}
};
