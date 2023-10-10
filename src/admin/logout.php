<?php
require_once 'config.php';

// Initialize the session
session_start();

if ($db->loggedIn()) {
    // If the user is logged in, log them out.
    $_SESSION = array();
    session_destroy();
    $response = [
        'message' => 'Logout successful.',
    ];
} else {
    // If the user is not logged in, return an error message.
    $response = [
        'error' => 'User is not logged in.',
    ];
}

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the response as JSON
echo json_encode($response);
