<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if (!empty($params[0])) {
		$response = json_decode(BotHttp::GET("http://xkcd.com/" . intval($params[0]) . "/info.0.json"));
		return $response->img;
	} else {
		$response = json_decode(BotHttp::GET("http://xkcd.com/info.0.json"));
		return $response->img;
	}
};
