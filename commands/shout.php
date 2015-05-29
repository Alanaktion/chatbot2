<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if (!empty($params[0])) {
		if($params[0] == "fonts") {
			$response = BotHttp::GET("https://artii.herokuapp.com/fonts_list");
			$response = implode(", ", explode("\n", $response));
			return "\n" . $response;
		} elseif(substr($params[0], 0, 5) == "font=") {
			$font = substr($params[0], 5);
			unset($params[0]);
			$param_str = implode(" ",$params);
			$response = BotHttp::GET("https://artii.herokuapp.com/make?text=" . urlencode($param_str) . "&font=" . urlencode($font));
			Bot::replyHtml($msg, "<br /><p style='font-family: monospace;'> " . nl2br(htmlentities(rtrim($response))) . '</p>', "\n" . rtrim($response));
		} else {
			$param_str = implode(" ",$params);
			$response = BotHttp::GET("https://artii.herokuapp.com/make?text=" . urlencode($param_str));
			Bot::replyHtml($msg, "<br /><p style='font-family: monospace;'> " . nl2br(htmlentities(rtrim($response))) . '</p>', "\n" . rtrim($response));
		}
	} else {
		return "Usage: #shout [fonts|font=font] <words, yo>";
	}
};
