<?php

// Function to get user's real IP address
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

    // Validate IP address format (optional, depending on your needs)
    if (filter_var($ip, FILTER_VALIDATE_IP)) {
        return $ip;
    } else {
        return false; // Return false if IP address is not valid
    }
}

// Function to handle API request based on endpoint
function handleRequest() {
    if (isset($_GET['endpoint'])) {
        $endpoint = $_GET['endpoint'];

        switch ($endpoint) {
            case 'get_ip':
                $userIP = getUserIP();

                if ($userIP) {
                    // Create response data array
                    $data = [
                        'user_ip' => $userIP
                    ];

                    // Return JSON response
                    return jsonResponse($data);
                } else {
                    return errorResponse('Failed to retrieve user IP address');
                }
                break;

            case 'build_url':
                $userIP = getUserIP();

                if ($userIP) {
                    // Example URL to build
                    $exampleURL = "https://ip-api.com/#$userIP";

                    // Create response data array
                    $data = [
                        'url' => $exampleURL
                    ];

                    // Return JSON response
                    return jsonResponse($data);
                } else {
                    return errorResponse('Failed to retrieve user IP address');
                }
                break;

            default:
                return errorResponse('Invalid endpoint');
                break;
        }
    } else {
        return errorResponse('Endpoint parameter missing');
    }
}

// Function to format response as JSON
function jsonResponse($data) {
    header('Content-Type: application/json');
    return json_encode($data, JSON_PRETTY_PRINT);
}

// Function to format error response as JSON with appropriate HTTP status code
function errorResponse($message) {
    header('Content-Type: application/json');
    http_response_code(400); // Bad request status code
    $errorData = [
        'error' => $message
    ];
    return json_encode($errorData, JSON_PRETTY_PRINT);
}

// Handle the request and output the response
echo handleRequest();

?>
