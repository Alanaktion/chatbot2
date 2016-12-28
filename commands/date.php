<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if(!empty($params)) {
		date_default_timezone_set(TZ);
		Bot::reply($msg, date(implode(" ", $params)));
		date_default_timezone_set("UTC");
	} else {
		return "Usage: #date <format>";
	}
};
