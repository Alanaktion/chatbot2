<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {

	if (!empty($params[0])) {
		$param_str = implode(" ",$params);
		$response = BotHttp::GET("http://isithackday.com/arrpi.php?text=" . urlencode($param_str));
		return $response;
	} else {
		return "Usage: #pirate <sentence>";
	}

};
