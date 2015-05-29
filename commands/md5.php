<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if(empty($params)) {
		return "Usage: #man <search terms>";
	} else {
		return md5(implode(" ", $params));
	}
};
