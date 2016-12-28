<?php

// Save timezone to constant before resetting to UTC
define('TZ', @date_default_timezone_get() ?: "UTC");

// Pre-load all libraries
require_once __DIR__ . "/sjaxl.php";
require_once __DIR__ . "/bot.php";
require_once __DIR__ . "/chatterbotapi.php";
require_once __DIR__ . "/twitteroauth.php";
require_once __DIR__ . "/phpQuery-onefile.php";
require_once __DIR__ . "/Unirest.php";
