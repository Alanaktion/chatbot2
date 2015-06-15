<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	global $config;
	$strs = array();
	foreach($config['aliases'] as $i=>$v) {
		$strs[] = "$i -> $v";
	}
	return 'Aliases: ' . implode(', ', $strs);
};
