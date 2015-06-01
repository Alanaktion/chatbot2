<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if (!empty($params[0])) {
		$text = implode(" ",$params);
		$result = json_decode(BotHttp::GET("http://api.urbandictionary.com/v0/define?term=" . urlencode($text)));
		if($result->result_type != "no_results") {
			$def = $result->list[0];
			$str = $def->word . ": " . $def->definition . "\n";
			$str .= "\"" . $def->example . "\"";
			return $str;
		} else {
			return "Nada.";
		}
	} else {
		return "Usage: #ud <word>";
	}
};
