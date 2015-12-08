<?php
$config = array(

	// Core
	"jid" => "chatbot@chat.example.com",
	"pass" => "passw0rd",
	"host" => "chat.example.com",

	// Multi-user Chat
	"muc" => array(
		"enabled" => false,
		"room" => "chatroom",
		"server" => "conference.chat.example.com",
		"nick" => "Chatbot",
		"password" => "roomPassw0rd",
	),

	// API Keys, etc.
	"twitter" => array(
		"ConsumerKey" => "",
		"ConsumerSecret" => "",
		"OAuthToken" => "",
		"OAuthSecret" => "",
	),
	"youtube_key" => "",
	"mashape_key" => "",
	"google_key" => "",
	"google_cse_id" => "",

	// Command aliases
	"aliases" => array(
		"=" => "math",
		"arand" => "array-rand",
		"leet" => "1337",
		"yt" => "youtube",
	),

);
