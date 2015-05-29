<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if(empty($params)) {
		return "Usage: #lmgtfy <query>";
	} else {
		return "http://lmgtfy.com/?q=" . urlencode(implode(" ",$params));
	}
};
