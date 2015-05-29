<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if(!empty($params[0])) {
		$param_str = implode(" ",$params);
		$url = "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=" . urlencode($param_str);
		$body = BotHttp::GET($url);
		$response = json_decode($body);
		if(!empty($response->responseData->results)) {
			$index = array_rand($response->responseData->results);
			return $response->responseData->results[$index]->titleNoFormatting . " - " . $response->responseData->results[$index]->unescapedUrl;
		} else {
			return "Nada.";
		}
	} else {
		return "Usage: #showme <search terms>";
	}
};
