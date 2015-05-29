<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {

	global $chat_factory, $chat_j, $chat_session_j;

	if(!isset($chat_factory)) {
		$chat_factory = new ChatterBotFactory();
	}
	if(!isset($chat_j)) {
		$chat_j = $chat_factory->create(ChatterBotType::JABBERWACKY);
	}
	if(!isset($chat_session_j)) {
		$chat_session_j = $chat_j->createSession();
	}

	if (!empty($params[0])) {
		$param_str = implode(" ",$params);
		$response = $chat_session_j->think($param_str);
		$response = strip_tags(str_replace(array("<br />","<br>","<br/>"),"\r\n",$response));
		_info("Jabberwacky response: " . trim($response));
		return trim($response);
	} else {
		return "Usage: #j <words, yo>";
	}

};
