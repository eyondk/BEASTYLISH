<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Proxy script
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.paymongo.com/v1/links'); // Ensure the URL is correct
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents('php://input'));

$headers = getallheaders();
if (isset($headers['Authorization'])) {
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        // 'Authorization: ' . $_SERVER['HTTP_AUTHORIZATION'], // Pass the Authorization header from the request
        // 'Authorization:' . $headers['Authorization'],
    ]);
} else {
    // Handle missing Authorization header
    header('Content-Type: application/json');
    echo json_encode([
        'error' => 'authentication_invalid',
        'detail' => 'You need to use basic authentication to proceed. Go to https://developers.paymongo.com/docs/authentication to know more about our API authentication.'
    ]);
    exit;
}

$response = curl_exec($ch);

if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
}

curl_close($ch);

if (isset($error_msg)) {
    // Log error message or handle it appropriately
    header('Content-Type: application/json');
    echo json_encode(['error' => $error_msg]);
    exit;
}

header('Content-Type: application/json');
echo $response;
?>
