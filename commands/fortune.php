<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {

	if (!empty($params[0])) {
		$url = "raw&q=" . $params[0];
	} else {
		$url = "raw";
	}

	$response = BotHttp::GET("http://phpizza.com/~alan/fortune.php?" . $url);
	return trim($response);

};
