<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {

	if(empty($params)) {

		// Show command list
		$list = scandir(__DIR__);
		$commands = array();
		foreach($list as $file) {
			if(substr($file, -4) == '.php') {
				$commands[] = substr($file, 0, strlen($file) - 4);
			}
		}

		$count = count($commands);
		Bot::reply($msg, "Available commands ($count): " . implode(", ", $commands));

	} else {

		// Show single command help
		$file = __DIR__ . "/{$params[0]}.txt";
		if(is_file($file)) {
			Bot::reply($msg, file_get_contents($file));
		} else {
			Bot::reply($msg, "Help is not available for {$params[0]}. Try running the command without any parameters.");
		}

	}

};
