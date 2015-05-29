<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $config;

	if(isset($params[0])) {
		$tweet = new TwitterOAuth($config["twitter"]["ConsumerKey"], $config["twitter"]["ConsumerSecret"], $config["twitter"]["OAuthToken"], $config["twitter"]["OAuthSecret"]);
		$message = implode(" ", $params);
		if(strlen($message) > 140) {
			return "Error: tweets must be 140 characters or less. That message is " . strlen($message) . ".";
		}

		$post = $tweet->post("statuses/update", array("status" => $message));
		if(!empty($post->id)) {
			return "Tweet posted: https://twitter.com/{$post->user->screen_name}/statuses/{$post->id_str}";
		} else {
			return "Failed to post tweet!";
		}
	} else {
		return "Usage: #tweet <message>";
	}
};
