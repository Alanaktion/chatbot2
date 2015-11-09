<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	$number = (isset($params[0]) && $params[0] > 0) ? min(100, $params[0]) : 0;
	$response = BotHttp::GET("https://catfacts-api.appspot.com/api/facts" . ($number ? '?number=' . $number : ''));
	$obj = json_decode($response);
	return implode("\n", $obj->facts);
};
