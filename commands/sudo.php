<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if(!empty($params[0])) {
		return "Okay.";
	} else {
		return "Usage: #sudo <command>";
	}
};
