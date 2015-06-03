<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if (!empty($params[0])) {
		$param_str = implode(" ",$params);

		$short_from = mb_substr($msg->from, 0, mb_strpos($msg->from, "@"));
		if ($msg->type == "groupchat" && mb_strpos($msg->from,"/")) {
			$short_from = mb_substr($msg->from, mb_strpos($msg->from, "/") + 1);
		}

		return $short_from . " slaps " . $param_str;
	} else {
		return "Usage: #slap <name>";
	}
};
