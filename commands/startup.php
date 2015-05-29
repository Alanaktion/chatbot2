<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	$response = json_decode(BotHttp::GET("http://itsthisforthat.com/api.php?json"));
	return $response->this . " for " . $response->that;
};
