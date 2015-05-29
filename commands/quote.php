<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	return trim(BotHttp::GET("http://www.iheartquotes.com/api/v1/random?max_lines=1&show_source=false&show_permalink=false"));
};
