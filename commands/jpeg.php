<?php
// Google's a random image for the terms, then more jpegs it.
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if(!empty($params[0])) {
		$param_str = implode(" ",$params);
		$url = "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=" . urlencode($param_str);
		$body = BotHttp::GET($url);
		$response = json_decode($body);
		if(!empty($response->responseData->results)) {
			Bot::reply($msg, "Found image, JPEGing it..");
			$index = array_rand($response->responseData->results);
			$src = $response->responseData->results[$index]->unescapedUrl;
			$result = BotHttp::POST("http://needsmorejpeg.com/process", array("image" => $src), null);
			print_r($result);
			if(preg_match("#/i/[0-9a-z]+\\.jpe?g#i", $result, $matches)) {
				print_r($matches);
				$jpeg = $matches[0];
				return $response->responseData->results[$index]->titleNoFormatting . " - http://needsmorejpeg.com" . $jpeg;
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
