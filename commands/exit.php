<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if($msg->type == "chat") {
		if(strpos($msg->from, "ahardman") !== false) {
			Bot::reply($msg,"/me dies");
			$client->send_end_stream();
		} else {
			Bot::reply($msg,"Only my master can kill me!");
		}
	} else {
		Bot::reply($msg,"/me decides not to die.");
	}
};
