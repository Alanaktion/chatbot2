<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if (isset($params[1])) {
		shuffle($params);
		return implode(" ", $params);
	} elseif (isset($params[0])) {
		return str_shuffle($params[0]);
	} else {
		return "Usage: #shuffle <word> [word]";
	}
};
