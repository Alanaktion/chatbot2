<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	$options = array(
		"q" => implode(" ", $params),
		"type" => "track",
		"market" => "US",
		"limit" => 1,
		"offset" => 0
	);
	$headers = array(
		"Accept: application/json"
	);
	$req = \BotHTTP::GET("https://api.spotify.com/v1/search?" . http_build_query($options), $headers);
	$obj = json_decode($req);
	$track = $obj->tracks->items[0];
	return $track->artists[0]->name . " - " . $track->name . ' - ' . $track->external_urls->spotify;
};
