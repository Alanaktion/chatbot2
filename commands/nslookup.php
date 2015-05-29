<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if(!empty($params[0])) {
		$result = gethostbyname($params[0]);
		if(!empty($result)) {
			return $result;
		} else {
			return "No matching hosts found.";
		}
	} else {
		return "Usage: #nslookup <host>";
	}
};
