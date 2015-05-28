<?php

/**
 * Bot
 * Core bot functionality static methods
 */
class Bot {

	public static $defaultConfig = array(
			"port" => 5222,
			"log_level" => JAXL_INFO
		);

	/**
	 * Loads config and starts a bot instance
	 * @return JAXL
	 */
	public static function instance() {
		global $client;
		if(!isset($client)) {
			// Create a new client
			$config = self::config();
			$client = new JAXL($config);

			// Handle XMPP events
			$client->add_cb("on_stream_start", function() {
				_debug("Client connected to server.");
			});
			$client->add_cb("on_auth_success", function() {
				global $client;
				_info("Client authenticated successfully.");
				$client->set_status("Available");
				$client->get_vcard();
				$client->get_roster();
			});
			$client->add_cb("on_chat_message", function($msg) {
				global $client, $last_command;
				if($msg == '##') {
					Bot::runCommand($last_command, $msg);
					return;
				} else {
					Bot::runCommand(ltrim($msg->body, '#'), $msg);
				}
			});
			$client->add_cb("on_groupchat_message", function($msg) {
				global $client, $last_command;
				if($msg == '##') {
					Bot::runCommand($last_command, $msg);
					return;
				} elseif(substr($msg, 0, 1) == "#") {
					Bot::runCommand(ltrim($msg->body, '#'), $msg);
				}
			});
			$client->add_cb("on_disconnect", function() {
				_info("Client disconnected.");
			});

			// Start the client
			$client->start();
		}
		return $client;
	}

	/**
	 * Build JAXL config array
	 * @return array
	 */
	public static function config() {
		include dirname(__DIR__) . '/config.php';
		return $config + self::$defaultConfig;
	}

	/**
	 * Send a reply message
	 * @param  object $original_msg
	 * @param  string $body
	 * @return void
	 */
	public static function reply($original_msg, $body) {
		global $client;
		$original_msg->to = $original_msg->from;
		$original_msg->from = $client->full_jid->to_string();
		$original_msg->body = $body;
		$client->send($original_msg);
	}

	/**
	 * Run a command
	 * @param  string $command_str
	 * @param  object $msg
	 * @return void
	 */
	public static function runCommand($command_str, $msg) {
		global $client, $last_command;

		$params = explode(" ", $command_str);
		$command = array_shift($params);
		$file = dirname(__DIR__) . "/commands/$command.php";

		if(!$command) {
			return;
		}

		if(is_file($file)) {

			// Store last command
			$last_command = $command_str;

			// Run command function
			$fn = require($file);
			$result = $fn($client, $msg, $params);

			if($result !== null) {
				Bot::reply($msg, $result);
			}

		} else {
			_info("Command $command does not exist.");
		}

	}

}
