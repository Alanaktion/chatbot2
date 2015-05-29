<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {

	if (!empty($params[0])) {
		$param_str = implode(" ",$params);
		if(rand(1,10) == 1) {
			return $param_str . "'s fail level is over 9000!!!!!!!11";
		} else {
			return "On a fail of 1-100, " . $param_str . " failed at " . rand(1, 100) . ".";
		}
	} else {
		return "Usage: #fail <who failed>";
	}

};
