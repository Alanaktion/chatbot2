<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $muc_jid;

	if(count($params) < 2) {
		return "Usage: #tell <user|groupchat> <message>";
	} else {
		$to = array_shift($params);
		$msg = implode(" ", $params);
		if($to == "groupchat" || $to == "group" || $to == "chat") {
			$client->xeps['0045']->send_groupchat(substr($muc_jid, 0, strpos($muc_jid, '/')), $msg);
		} else {
			$client->send_chat_msg($to, $msg);
		}
	}
};
