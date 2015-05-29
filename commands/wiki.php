<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	if (!empty($params[0])) {
		$param_str = implode(" ",$params);
		$url = "https://en.wikipedia.org/w/api.php?action=query&prop=info&format=json&titles=" . urlencode($param_str);
		$response = json_decode(BotHttp::GET($url));
		if(!empty($response->query->pages)) {
			foreach($response->query->pages as $curpage) {
				$page = $curpage;
				break;
			}
			return "https://en.wikipedia.org/wiki/" . ucfirst(str_replace(" ", "_", $page->title));
		} else {
			return "Nothing found!";
		}
	} else {
		return "Usage: #wiki <search terms>";
	}
};
