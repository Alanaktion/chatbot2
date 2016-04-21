<?php
// Google's a random image for the terms, then more jpegs it.
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $config;
	if(!empty($params[0])) {
		$param_str = implode(" ",$params);
		$httpParams = array(
			"q" => $param_str,
	        "searchType" => "image",
	        "key" => $config['google_key'],
	        "cx" => $config['google_cse_id'],
		);
		$url = "https://www.googleapis.com/customsearch/v1?" . http_build_query($httpParams);
		$body = BotHttp::GET($url);
		$response = json_decode($body);
		if(!empty($response->items)) {
			$index = array_rand($response->items);
			$src = $response->items[$index]->link;
			$result = BotHttp::POST("http://needsmorejpeg.com/upload", array("image" => $src), null);
			if(preg_match("#/i/[0-9a-z]+\\.jpe?g#i", $result, $matches)) {
				$jpeg = $matches[0];
				return $response->items[$index]->title . " - http://needsmorejpeg.com" . $jpeg;
			} else {
				return "Failed to JPEG :(";
			}
		} else {
			return "Nada.";
		}
	} else {
		return "Usage: #jpeg <search terms>";
	}
};
