<?php
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
			return $response->items[$index]->title . " - " . $response->items[$index]->link;
		} else {
			return "Nada.";
		}
	} else {
		return "Usage: #showme <search terms>";
	}
};
