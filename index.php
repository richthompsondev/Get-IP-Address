<?php
// Function to get real IP address
function getRealIpAddr() {
    $headers = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
    foreach ($headers as $header) {
        if (!empty($_SERVER[$header])) {
            $ip = filter_var($_SERVER[$header], FILTER_VALIDATE_IP);
            if ($ip !== false) {
                return $ip;
            }
        }
    }
    return '0.0.0.0'; // Default if no valid IP is found
}

// Get the endpoint from the URL parameter
$endpoint = $_GET['endpoint'] ?? '';

// Handle different endpoints
switch ($endpoint) {
    case 'get_ip':
        $ip = getRealIpAddr();
        header('Content-Type: application/json');
        echo json_encode(['ip' => $ip]);
        break;

    case 'build_url':
        $ip = getRealIpAddr();
        $url = "https://ip-api.com/#{$ip}";
        header('Content-Type: application/json');
        echo json_encode(['url' => $url]);
        break;

    case 'build_url_compose':
        $ip = getRealIpAddr();
        $url = "http://ip-api.com/json/{$ip}?fields=66842623&lang=en";
        header('Content-Type: application/json');
        echo json_encode(['url' => $url]);
        break;

    default:
        echo "Welcome; silence is golden";
        break;
}
