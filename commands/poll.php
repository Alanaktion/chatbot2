<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {

	if (!empty($params[0])) {
		switch($params[0]) {
			case "new":
				if(empty($params[1])) {
					return "Usage: #poll new [choice1, choice2, ...]" . implode("\n", $stats);
				}
				if(isset($GLOBALS['poll'])) {
					return "There is already a running poll. The creator of the current poll can end it with #poll end." . implode("\n", $stats);
				}
				break;
			case "end":
				if(isset($GLOBALS['poll'])) {
					return "There is already a running poll. The creator of the current poll can end it with #poll end." . implode("\n", $stats);
				}
				break;
			case "vote":
				if(empty($params[1])) {
					return "Usage: #poll vote <choice #>" . implode("\n", $stats);
				}
				break;
		}
	} else {
		if(isset($GLOBALS['poll'])) {
			$stats = array();
			return "Current poll statistics: " . implode("\n", $stats);
		} else {
			return "No open polls. Use \"#poll new [choice1, choice2, ...]\" to start a new poll.";
		}
	}

};
