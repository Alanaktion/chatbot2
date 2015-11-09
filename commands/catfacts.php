<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	$response = BotHttp::GET("https://catfacts-api.appspot.com/api/facts");
	$obj = json_decode($response);
	return $obj->facts[0];
};
