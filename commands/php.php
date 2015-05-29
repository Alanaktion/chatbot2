<?php
return function(JAXL $client, XMPPStanza $msg, array $params) use($wordlist) {

	if(!empty($params[0])) {
		$html = BotHttp::GET("http://www.php.net/manual/en/function." . str_replace("_", "-", $params[0]) . ".php");
		$doc = phpQuery::newDocumentHtml($html);

		// Function type/name/params
		$msg = "<span style='color: #693;'>" . $doc['.methodsynopsis > .type']->text() . "</span> ";
		$function_name = $doc['.methodsynopsis .methodname']->text();
		$msg .= "<a href='http://php.net/" . str_replace("_", "-", $function_name) . "'>{$function_name}</a> ";
		$msg .= "<span style='color: #737373;'>( ";
		foreach($doc['.methodsynopsis .methodparam'] as $i=>$param) {
			$p = pq($param);
			$optional = !!$p->find(".initializer")->text();

			if($i) {
				if($optional) {
					$msg .= " [, ";
				} else {
					$msg .= " , ";
				}
			} elseif($optional) {
				$msg .= "[";
			}

			$msg .= htmlspecialchars($p->text());

			if($optional) {
				$msg .= " ]";
			}
		}
		$msg .= " )</span>";

		// Add description
		foreach($doc['.refsect1.description .para'] as $para) {
			$msg .= "<br />\n" . htmlspecialchars(trim(preg_replace(array("/[^(\x20-\x7F)]*/", "/\s+/"), array("", " "), pq($para)->text())));
		}

		// TODO: Implement HTML messages in core, use here
		// $conn->htmlmessage($event['from'], $msg, $event['type']);
		return $msg;
	} else {
		return "Usage: #php <function name>";
	}

};
