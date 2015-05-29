<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if (!empty($params[0])) {
		$param_str = implode(" ",$params);
		$array_of_lots_of_stuff = array('soda','donut','quarter','punch in the face');

		$short_from = mb_substr($pl['realfrom'], 0, mb_strpos($pl['realfrom'], "@"));
		if ($pl['type'] == "groupchat" && mb_strpos($pl['realfrom'],"/")) {
			$short_from = mb_substr($pl['realfrom'], mb_strpos($pl['realfrom'], "/") + 1);
		}

		return $param_str . " owes " . $short_from . " a " . $array_of_lots_of_stuff[array_rand($array_of_lots_of_stuff)];
	} else {
		return "Usage: #jinx <name>";
	}
};
