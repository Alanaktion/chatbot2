<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	try {
		if (!empty($params[0])) {
			$categories = array("hats","space","funny","sunglasses","boxes","caturday","ties","dream","kittens","sinks","clothes");
			if($params[0] == "gif" && empty($params[1])) {
				$cat_xml = BotHttp::GET("http://thecatapi.com/api/images/get?format=xml&type=gif");
				$cat = new SimpleXMLElement($cat_xml);
				return $cat->data->images->image->url;
			} elseif(in_array($params[0],$categories)) {
				$url = "http://thecatapi.com/api/images/get?format=xml&category=" . urlencode($params[0]);
				if(!empty($params[1]) && $params[1] == "gif") {
					$url .= "&type=gif";
				}

				$cat_xml = BotHttp::GET($url);
				$cat = new SimpleXMLElement($cat_xml);
				if(!empty($cat->data->images)) {
					return $cat->data->images->image->url;
				} else {
					return "No kittehs here :(";
				}
			} else {
				return "Available categories: " . implode(" ",$categories);
			}
		} else {
			$cat_xml = BotHttp::GET("http://thecatapi.com/api/images/get?format=xml");
			$cat = new SimpleXMLElement($cat_xml);
			return $cat->data->images->image->url;
		}
	} catch(Exception $ex) {
		echo $cat_xml;
		return "Failed to get a kitteh!";
	}
};
