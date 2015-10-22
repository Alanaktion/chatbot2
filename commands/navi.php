<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	$responses = array("Hey!", "Hey!", "Listen!");
	return $responses[array_rand($responses)];
};
