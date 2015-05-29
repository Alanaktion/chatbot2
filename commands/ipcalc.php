<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	return BotHttp::GET("http://bot.whatismyipaddress.com/");
};
