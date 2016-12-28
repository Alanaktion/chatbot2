<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {

	if (!empty($params[0])) {
		switch ($params[0]) {
			case "new":
				if (empty($params[1])) {
					return "Usage: #poll new [choice1, choice2, ...]";
				}
				if (isset($GLOBALS['poll'])) {
					return "There is already a running poll. The creator of the current poll can end it with #poll end.";
				}

				array_shift($params);

				$GLOBALS['poll'] = array(
					'user' => $msg->from,
					'choices' => array_values($params),
					'votes' => array()
				);
				return 'Poll created! Vote with "#poll vote <choice #>"';

			case "end":
				if (!isset($GLOBALS['poll'])) {
					return "No polls are currently running.";
				}
				if ($GLOBALS['poll']['user'] != $msg->from) {
					return "Only the creator of the poll can end it.";
				}
				$poll = $GLOBALS['poll'];
				$GLOBALS['poll'] = null;
				// @todo: Show poll results
				return "Poll closed.";

			case "vote":
				if (empty($params[1])) {
					return "Usage: #poll vote <choice #>" . implode("\n", $stats);
				}
				break;
		}
	} else {
		if (isset($GLOBALS['poll'])) {
			$stats = array();
			return "Current poll statistics: " . implode("\n", $stats);
		} else {
			return "No open polls. Use \"#poll new [choice1, choice2, ...]\" to start a new poll.";
		}
	}

};
