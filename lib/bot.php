<?php

/**
 * Bot
 * Core bot functionality static methods
 */
class Bot {

	public static $defaultConfig = array(
			"protocol" => "tcp",
			"port" => 5222,
			"log_level" => JAXL_INFO
		);

	/**
	 * Loads config and starts a bot instance
	 * @return JAXL
	 */
	public static function instance() {
		global $client, $config;
		if(!isset($client)) {

			// Create a new client
			$config = self::config();
			$client = new SJAXL($config);

			// Enable MUC support
			$client->require_xep(array('0045'));

			// Handle XMPP events
			$client->add_cb("on_stream_start", function() {
				_debug("Client connected to server.");
			});
			$client->add_cb("on_auth_success", function() use($config) {
				global $client, $muc_jid;
				_info("Client authenticated successfully.");
				$client->set_status("Available");
				$client->get_vcard();
				$client->get_roster();

				// Join chat room if MUC was configured
				if(!empty($config["muc"]["enabled"])) {
					$muc_jid = $config["muc"]["room"] . '@' . $config["muc"]["server"] . '/' . $config["muc"]["nick"];
					$muc_options = array('no_history' => true);
					if(!empty($config["muc"]["password"])) {
						$muc_options["password"] = $config["muc"]["password"];
					}
					_info("Joining room {$muc_jid}...");
					$client->xeps['0045']->join_room($muc_jid, $muc_options);
				}

			});
			$client->add_cb("on_chat_message", function($msg) {
				global $last_command;
				if($msg->body == '##') {
					Bot::runCommand($last_command, $msg);
					return;
				} elseif($msg->body) {
					Bot::runCommand(ltrim($msg->body, '#'), $msg);
				}
			});
			$client->add_cb("on_groupchat_message", function($msg) {
				global $last_command;
				if($msg->body == '##') {
					Bot::runCommand($last_command, $msg);
					return;
				} elseif(substr($msg->body, 0, 1) == "#") {
					Bot::runCommand(ltrim($msg->body, '#'), $msg);
				}
			});
			$client->add_cb("on_presence_stanza", function($msg) use($client) {
				$type = ($msg->type ?: "available");
				$show = ($msg->show ? ' (' . $msg->show . ')' : '');
				// _info($msg->from . " is now " . $type . $show);

				switch($type) {
					case "available":
						$client->get_vcard($msg->from);
						break;
					case "subscribe":
						$client->subscribe($msg->from);
						break;
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
	 * @param  XMPPStanza $original_msg
	 * @param  string $body
	 * @return void
	 */
	public static function reply(XMPPStanza $original_msg, $body) {
		global $client, $muc_jid;

		if($original_msg->type == 'groupchat') {
			$client->xeps['0045']->send_groupchat(substr($muc_jid, 0, strpos($muc_jid, '/')), $body);
		} else {
			$msg = new XMPPMsg(array(
				'type' => 'chat',
				'to' => $original_msg->from,
				'from' => $client->full_jid->to_string()
			), $body);
			$client->send($msg);
		}
	}

	/**
	 * Send a reply message with HTML
	 * @param  XMPPStanza $original_msg
	 * @param  string $html
	 * @param  string $plaintext
	 * @return void
	 */
	public static function replyHtml(XMPPStanza $original_msg, $html, $plaintext = null) {
		global $client, $muc_jid;

		if($plaintext === null) {
			$plaintext = strip_tags($html);
		}

		if($original_msg->type == 'groupchat') {
			$type = 'groupchat';
			$to = substr($muc_jid, 0, strpos($muc_jid, '/'));
		} else {
			$type = 'chat';
			$to = $original_msg->from;
		}

		$msg = new XMPPMsg(array(
			'type' => $type,
			'to' => $to,
			'from' => $client->full_jid->to_string()
		), $plaintext);
		$msg->c('html', null, array('xmlns' => 'http://jabber.org/protocol/xhtml-im'))
			->c('body', null, array('xmlns' => 'http://www.w3.org/1999/xhtml'))
			->x($html);
		$client->send($msg);
	}

	/**
	 * Find a command's PHP file
	 * @param  string $command_str
	 * @return string|FALSE
	 */
	public static function findCommand($command) {
		global $config;
		$root = dirname(__DIR__)."/commands/";
		if(isset($config['aliases'][$command])) {
			$command = $config['aliases'][$command];
		}
		if(is_file($root.$command.".php")) {
			return $root.$command.".php";
		}
		foreach(scandir($root) as $dir) {
			if($dir{0} != "." && is_dir($root.$dir)) {
				if(is_file($root.$dir."/".$command.".php")) {
					return $root.$dir."/".$command.".php";
				}
			}
		}
		return false;
	}

	/**
	 * Run a command
	 * @param  string $command_str
	 * @param  object $msg
	 * @return void
	 */
	public static function runCommand($command_str, $msg) {
		global $client, $last_command;

		$params = explode(" ", html_entity_decode($command_str));
		$command = array_shift($params);

		if(!$command || strpos($command, ".") !== false) {
			return;
		}

		_info("{$msg->from}: {$command_str}");

		$file = self::findCommand($command);
		if($file) {

			// Store last command
			$last_command = $command_str;

			// Run command function
			$fn = require($file);
			try {
				$result = $fn($client, $msg, $params);
				if($result !== null) {
					Bot::reply($msg, $result);
				}
			} catch(Exception $e) {
				Bot::reply($msg, "ERR: " . $e->getMessage());
			}

		} else {
			_notice("Command $command does not exist.");
		}

	}

	/**
	 * Flush the stream's write buffer
	 * @return void
	 */
	public static function flush() {
		global $client;
		$transport = $client->getTransport();
		$transport->on_write_ready($transport->fd);
	}

}

/**
 * Bot
 * HTTP request static methods using curl
 */
class BotHttp {

	/**
	 * Perform a HTTP GET request on a URL
	 * @param  string $url
	 * @param  string|array $user_agent  User agent string or array of headers
	 * @return string
	 */
	public static function GET($url, $user_agent = null) {
		_info('HTTP-GET: ' . $url);
		if (in_array('curl', get_loaded_extensions())) {
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			if(is_array($user_agent)) {
				curl_setopt($curl, CURLOPT_HTTPHEADER, $user_agent);
			} elseif($user_agent) {
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('User-Agent: ' . $user_agent));
			}
			$data = curl_exec($curl);
			curl_close($curl);
		} else {
			$data = file_get_contents($url);
		}
		return $data;
	}

	/**
	 * Perform a HTTP POST request on a URL
	 * @param  string $url
	 * @param  array  $post_data
	 * @param  string $content_type
	 * @return string
	 */
	public static function POST($url, $post_data = array(), $content_type = "application/json") {
		_info('HTTP-POST: ' . $url);
		if (in_array('curl', get_loaded_extensions())) {
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
			if($content_type) {
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: ' . $content_type));
			}
			$data = curl_exec($curl);
			curl_close($curl);
		} else {
			$data = file_get_contents($url);
		}
		return $data;
	}

}
