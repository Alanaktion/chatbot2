<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $config;
	$config = Bot::config();
	return "Configuration reloaded.";
};
