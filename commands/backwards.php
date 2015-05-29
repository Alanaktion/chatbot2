<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if (!empty($params[0])) {
		return strrev(implode(" ", $params));
	} else {
		return "Usage: #backwards <words, yo>";
	}
};
