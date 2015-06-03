<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $config;
	if (!empty($params[0])) {
		$d = 2;
		if(preg_match("/^[0-9]+d$/i", trim($params[0])) && count($params) > 1) {
			$d = intval($params[0]);
			unset($params[0]);
		}

		$param_str = implode(' ',$params);
		Bot::reply($msg, "Checking the forecast for " . $param_str . "...");
		$response = Unirest::get("https://george-vustrey-weather.p.mashape.com/api.php?_method=getForecasts&location=" . urlencode($param_str), array("X-Mashape-Authorization" => $config["mashape_key"]));
		$str = "Forecast for " . $param_str;

		$str.= "\nToday: ▲ " . round($response->body[0]->high) . "  ▼ " . round($response->body[0]->low) . "  " . $response->body[0]->condition;
		$str.= "\nTomorrow: ▲ " . round($response->body[1]->high) . "  ▼ " . round($response->body[1]->low) . "  " . $response->body[1]->condition;

		if(count($response->body) < $d) {
			$d = count($response->body);
		}
		if($d > 2) {
			for($i = 2; $i < $d; $i++) {
				$day_name = date("l", strtotime("+{$i} days"));
				$str.= "\n{$day_name}: ▲ " . round($response->body[$i]->high) . "  ▼ " . round($response->body[$i]->low) . "  " . $response->body[$i]->condition;
			}
		}
		return $str;
	} else {
		return "Usage: #weather [Nd] <location>";
	}
};
