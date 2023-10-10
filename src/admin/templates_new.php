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
            'columns' => $_POST['columns'],
            'body' => $_POST['body'],
        ];

        // Insert the new template into the database
        $db->insertQuery($data, 'templates');

        // Prepare a success message for the response
        $response = [
            'message' => 'Added template successfully.',
        ];
    } else {
        // If the request is not a POST request, return a message indicating how to use the API.
        $response = [
            'message' => 'To add a new template, submit a POST request with the required data (name, columns, and body).',
        ];
    }
}

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the response as JSON
echo json_encode($response);
