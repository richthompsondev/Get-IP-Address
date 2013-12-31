<?php
function getUserIP() {
    // Check for the different headers that might contain the real IP address
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // Check for IP from shared internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Check for IP passed from a proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // Check for remote IP address
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    // Return the IP address
    return $ip;
}

// Get the user's IP address
$userIP = getUserIP();

// Create an associative array with the IP address
$data = [
    'user_ip' => $userIP
];

// Output the IP address in pretty JSON format
echo json_encode($data, JSON_PRETTY_PRINT);
?>
