<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	return implode(" ", $params);
};
