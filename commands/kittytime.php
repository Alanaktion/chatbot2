<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	date_default_timezone_set(TZ);
	$time = date("H:m:s");
	date_default_timezone_set("UTC");
	$output = <<<EOT
  __________
 < $time >
  ----------
   \
    \
       /\_)o<
      |      \
      | O . O|
       \_____/

EOT;
	Bot::replyHtml($msg, "<br /><p style='font-family: monospace;'> " . nl2br(htmlspecialchars($output)) . '</p>', "\n" . rtrim($output));
};
