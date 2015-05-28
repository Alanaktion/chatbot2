#!/usr/bin/php
<?php
/**
 * Chatbot2
 * @author Alan Hardman <alan@phpizza.com>
 */

if (!defined('STDIN')) {
	die("chatbot2 must be run from the command line.");
}

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/lib/bot.php';

$bot = Bot::instance();
