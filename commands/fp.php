<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {

	$img = str_pad(rand(1, 45), 2, 0, STR_PAD_LEFT);
	return "http://facepalm.org/images/{$img}.jpg";

};
