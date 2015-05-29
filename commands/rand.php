<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if(empty($params)) {
		$val = rand();
	} elseif(isset($params[1]) && is_numeric($params[0]) && is_numeric($params[1])) {
		$val = rand(intval($params[0]), intval($params[1]));
	} elseif(isset($params[0]) && is_numeric($params[0])) {
		$val = rand(1, intval($params[0]));
	}
	if(isset($val)) {
		return $val;
	} else {
		return "Usage: #rand [max] OR #rand [min] [max]";
	}
};
