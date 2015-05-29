<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if(empty($params)) {
		return "Usage: #sha1 <string>";
	} else {
		return sha1(implode(" ",$params));
	}
};
