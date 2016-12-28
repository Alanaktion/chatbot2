<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	return "Currently disabled for reasons.";
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
		} else {
			$param_str = implode(" ",$params);
			$response = BotHttp::GET("https://artii.herokuapp.com/make?text=" . urlencode($param_str));
		}
		if ($response) {
			$lines = explode("\n", $response);
			foreach($lines as $text) {
				$text = rtrim($text);
				$ret = "";
				$colors = array('ff00ff', 'ff00cc', 'ff0099', 'ff0066', 'ff0033', 'ff0000', 'ff3300', 'ff6600', 'ff9900', 'ffcc00', 'ffff00', 'ccff00', '99ff00', '66ff00', '33ff00', '00ff00', '00ff33', '00ff66', '00ff99', '00ffcc', '00ffff', '00ccff', '0099ff', '0066ff', '0033ff', '0000ff', '3300ff', '6600ff', '9900ff', 'cc00ff');
				$i = 0;
				$textlength = strlen($text);
				while($i <= $textlength) {
					foreach($colors as $value) {
						if (isset($text[$i]) && $text[$i] == " ") {
							$ret = "&nbsp;";
						} elseif (isset($text[$i])) {
							$ret .= '<span style="color:#'.$value.';">' . htmlentities($text[$i]) . "</span>";
						}
						$i++;
					}
				}

				echo $ret;

				Bot::replyHtml($msg, $ret, rtrim($text));
				Bot::flush();
			}
		}
	} else {
		return "Usage: #rainbowshout [fonts|font=font] <words, yo>";
	}
};
