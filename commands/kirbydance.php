<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	Bot::reply($msg, "<(^.^<)");
	sleep(1);
	Bot::reply($msg, "(>^.^)>");
	sleep(1);
	Bot::reply($msg, "<(^.^<)");
	sleep(1);
	Bot::reply($msg, "(>^.^)>");
	sleep(1);
	Bot::reply($msg, "^( ^.^ )^");
};
