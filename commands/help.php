<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {

	if(empty($params)) {

		// Show command list
		$list = scandir(__DIR__);
		$commands = array();
		foreach($list as $file) {
			if($file == '.' || $file == '..') {
				continue;
			}
			if(substr($file, -4) == '.php') {
				$commands[] = substr($file, 0, strlen($file) - 4);
			} elseif(is_dir(__DIR__ . '/' . $file)) {
				foreach(scandir(__DIR__ . '/' . $file) as $file2) {
					if(substr($file2, -4) == '.php') {
						$commands[] = substr($file2, 0, strlen($file2) - 4);
					}
				}
			}
		}

		$count = count($commands);
		return "Available commands ($count): " . implode(", ", $commands);

	} else {

		// Show single command help
		$file = dirname(__DIR__) . "/command-help/{$params[0]}.txt";
		if(is_file($file)) {
			return file_get_contents($file);
		} else {
			return "Help is not available for {$params[0]}. Try running the command without any parameters.";
		}

	}

};
