<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {

	if(isset($params[0])) {
		if($params[0] > 100) {
			return "Yeah, no";
		} elseif(intval($params[0]) > 0) {
			$lines = intval($params[0]);
		}
	} else {
		$lines = 30;
	}
	if(!empty($lines)) {
		return str_repeat("\n", $lines);
	} else {
		return "Usage: #clear [lines]";
	}

};
