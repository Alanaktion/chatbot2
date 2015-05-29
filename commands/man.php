<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if(empty($params)) {
		return "Usage: #man <search terms>";
	} else {
		return "http://linux.die.net/man/1/" . strtolower($params[0]);
	}
};
