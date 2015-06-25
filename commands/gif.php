<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if(!empty($params[0])) {
		$param_str = implode(" ",$params);
		$url = "http://api.giphy.com/v1/gifs/search?q=" . urlencode($param_str) . "&limit=20&api_key=dc6zaTOxFJmzC";
		$result = Unirest::get($url);
		if(!empty($result->body->data) && !empty($result->body->data[0])) {
			$i = array_rand($result->body->data);
			$img = $result->body->data[$i]->images->original;
			return $img->url;
		} else {
			return "Nada.";
		}
	} else {
		return "Usage: #gif <search terms>";
	}
};
