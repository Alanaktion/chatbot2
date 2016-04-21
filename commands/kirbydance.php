<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	Bot::reply($msg, "<(^.^<)");
	Bot::flush();
	sleep(1);
	Bot::reply($msg, "(>^.^)>");
	Bot::flush();
	sleep(1);
	Bot::reply($msg, "<(^.^<)");
	Bot::flush();
	sleep(1);
	Bot::reply($msg, "(>^.^)>");
	Bot::flush();
	sleep(1);
	Bot::reply($msg, "^( ^.^ )^");
};
