<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	date_default_timezone_set(TZ);
	Bot::reply($msg, date('r'));
	date_default_timezone_set("UTC");
};
