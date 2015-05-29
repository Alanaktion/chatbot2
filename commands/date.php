<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if(!empty($params)) {
		return date(implode(" ", $params));
	}
	return "Usage: #date <format>";
};
