<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $config, $devops_borat_feed;

	if(empty($devops_borat_feed)) {
		$twitter = new TwitterOAuth($config["twitter"]["ConsumerKey"], $config["twitter"]["ConsumerSecret"], $config["twitter"]["OAuthToken"], $config["twitter"]["OAuthSecret"]);
		$devops_borat_feed = $twitter->get("statuses/user_timeline", array("screen_name" => "DEVOPS_BORAT", "trim_user" => true, "count" => 3000));
	}

	$tweet = $devops_borat_feed[array_rand($devops_borat_feed)];

	if($tweet) {
		return $tweet->text;
	} else {
		_error(print_r($devops_borat_feed, true));
		unset($devops_borat_feed);
		return "Unable to load tweet :(";
	}

};
