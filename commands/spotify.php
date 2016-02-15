<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	$q = implode(" ", $params);
	$type = "album,artist,track";
	if(preg_match("/(track|song|artist|album|playlist)/", $q, $matches)) {
		$type = $matches[1];
		if($type == "song")
			$type = "track";
		$q = ltrim(str_replace($matches[0], "", $q));
	}
	$options = array(
		"q" => $q,
		"type" => $type,
		"market" => "US",
		"limit" => 1,
		"offset" => 0
	);
	$headers = array(
		"Accept: application/json"
	);
	$req = \BotHTTP::GET("https://api.spotify.com/v1/search?" . http_build_query($options), $headers);
	$obj = json_decode($req);
	switch($type) {
		case "track":
			$item = $obj->tracks->items[0];
			return $item->artists[0]->name . " - " . $item->name . " - " . $item->external_urls->spotify;
		case "artist":
			$item = $obj->artists->items[0];
			return $item->name . " - " . $item->external_urls->spotify;
		case "album":
			$item = $obj->albums->items[0];
			return $item->name . " - " . $item->external_urls->spotify;
		case "playlist":
			$item = $obj->playlists->items[0];
			return $item->name . " - " . $item->external_urls->spotify;
		default:
			$item = $obj->tracks->items[0];
			$return  = "\nTrack: " . $item->artists[0]->name . " - " . $item->name . " - " . $item->external_urls->spotify;
			$item = $obj->artists->items[0];
			$return .= "\nArtist: " . $item->name . " - " . $item->external_urls->spotify;
			$item = $obj->albums->items[0];
			$return .= "\nAlbum: " . $item->name . " - " . $item->external_urls->spotify;
		return $return;
	}
};
