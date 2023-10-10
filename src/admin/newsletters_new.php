<?php
require_once 'config.php';

$response = $db->loginRequired();

if (!$response) {
    // If the user is not logged in, return an error message.
    $response = [
        'error' => 'Authentication required. Please log in.',
    ];
} else {
    if (isset($_POST['submitted'])) {
        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
        ];

        // Insert the new newsletter into the database
        $db->insertQuery($data, 'newsletters');

        // Prepare a success message for the response
        $response = [
            'message' => 'Added newsletter successfully.',
        ];
    } else {
        // If the request is not a POST request, return a message indicating how to use the API.
        $response = [
            'message' => 'To add a new newsletter, submit a POST request with the required data (name and description).',
        ];
    }
}

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the response as JSON
echo json_encode($response);
