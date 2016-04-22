<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $muc_jid;

	if(!$params) {
		return "Usage: #invite <user> [comment]";
	} else {
		$user = array_shift($params);
		$msg = new XMPPMsg(array(
			'to' => substr($muc_jid, 0, strpos($muc_jid, '/'))
		));
		$msg->c('x', array('xmlns' => 'http://jabber.org/protocol/muc#user'))
			->c('invite', array('to' => $user));

		if($params) {
			$msg->c('comment')->t(implode(" ", $params));
		}

		$client->send($msg);
	}
};
