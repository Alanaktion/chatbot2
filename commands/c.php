<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {

	global $chat_factory, $chat_c, $chat_session_c;

	if(!isset($chat_factory)) {
		$chat_factory = new ChatterBotFactory();
	}
	if(!isset($chat_c)) {
		$chat_c = $chat_factory->create(ChatterBotType::CLEVERBOT);
	}
	if(!isset($chat_session_c)) {
		$chat_session_c = $chat_c->createSession();
	}

	if (!empty($params[0])) {
		$param_str = implode(" ",$params);
		$response = $chat_session_c->think($param_str);
		$response = strip_tags(str_replace(array("<br />","<br>","<br/>"),"\r\n",$response));
		_info("Cleverbot response: " . trim($response));
		return trim($response);
	} else {
		return "Usage: #c <words, yo>";
	}

};
