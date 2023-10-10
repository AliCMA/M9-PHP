<?php
require_once 'config.php';

if ($db->loggedIn()) {
    // If the user is already logged in, you can return a JSON response indicating that.
    $response = [
        'message' => 'User is already logged in.',
    ];
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['username']) && !empty($_POST['password'])) {
        $response = $db->validateUser($_POST['username'], $_POST['password']);

        if (!$response) {
            // If login fails, you can return a JSON response with an error message.
            $response = [
                'error' => 'Login error.',
            ];
        }
    } else {
        // If there's no POST data, you can return a JSON response with a message.
        $response = [
            'message' => 'Provide username and password via POST request to login.',
        ];
    }
}

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the response as JSON
echo json_encode($response);
