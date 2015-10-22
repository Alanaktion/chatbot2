<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if(empty($params)) {
		return "Usage: #md5 <string>";
	} else {
		return md5(implode(" ", $params));
	}
};
