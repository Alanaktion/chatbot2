<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $config, $devloper_feed;

	if(empty($devloper_feed)) {
		$twitter = new TwitterOAuth($config["twitter"]["ConsumerKey"], $config["twitter"]["ConsumerSecret"], $config["twitter"]["OAuthToken"], $config["twitter"]["OAuthSecret"]);
		$devloper_feed = $twitter->get("statuses/user_timeline", array("screen_name" => "IAMDEVLOPER", "trim_user" => true, "count" => 3000));
	}

	$tweet = $devloper_feed[mt_rand(0, count($devloper_feed) - 1)];

	if($tweet) {
		return $tweet->text;
	} else {
		_error(print_r($devloper_feed, true));
		unset($devloper_feed);
		return "Unable to load tweet :(";
	}

};
