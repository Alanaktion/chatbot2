<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $muc_jid;
	if(empty($params)) {
		return "Usage: #topic <message>";
	} else {
		if($msg->type == 'chat') {
			$topic = implode(" ", $params);
			$client->xeps['0045']->send_groupchat(substr($muc_jid, 0, strpos($muc_jid, '/')), null, null, $topic);
			return "Topic set!";
		}
	}
};
