<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $config;
	if (!empty($params[0])) {

		$param_str = implode(" ",$params);
		$url = "https://www.googleapis.com/youtube/v3/search?part=id%2Csnippet&type=video&q=" . urlencode($param_str) . "&key=" . urlencode($config["youtube_key"]);

		$result = json_decode(BotHttp::GET($url));

		if (isset($result->items[0])) {
			$video = $result->items[0];
			$url = 'https://www.youtube.com/watch?v=' . urlencode($video->id->videoId);
			$title = $video->snippet->title;

			return $url . " - " . $title;
		} else {
			return "Nothing found!";
		}

	} else {
		return "Usage: #yt|youtube <search terms>";
	}
};
