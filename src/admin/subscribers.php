<?php
require_once 'config.php';

$response = $db->loginRequired();

if (!$response) {
    // If the user is not logged in, return an error response.
    $response = [
        'error' => 'Authentication required. Please log in.',
    ];
} else {
    $title = "Subscribers";
    $tab = 'sub';

    // Retrieve subscribers from the database
    $subscribers = $db->query("SELECT * FROM subscribers ORDER BY id ASC");

    // Prepare a response array to store subscriber data
    $response = [
        'title' => $title,
        'tab' => $tab,
        'subscribers' => $subscribers,
    ];
}

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the response as JSON
echo json_encode($response);
