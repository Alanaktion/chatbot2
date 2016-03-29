<?php
return function(JAXL $client, XMPPStanza $msg, array $params) {
	$articles = array(
		"https://medium.com/@blakeross/mr-fart-s-favorite-colors-3177a406c775",
		"http://www.stilldrinking.org/programming-sucks",
	);
	return $articles[array_rand($articles)];
};
