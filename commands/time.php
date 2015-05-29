<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	return date('r');
};
