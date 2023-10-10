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
        $id = (int)$_POST['id'];

        if (isset($_POST['visible'])) {
            $visible = 1;
        } else {
            $visible = 0;
        }

        $data = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'visible' => $visible,
        ];

        // Update the newsletter in the database
        $db->updateQuery($data, $id, 'newsletters');

        // Prepare a success message for the response
        $response = [
            'message' => 'Updated newsletter successfully.',
        ];
    } else {
        // If the request is not a POST request, return a message indicating how to use the API.
        $response = [
            'message' => 'To edit a newsletter, submit a POST request with the required data (name, description, and visible status).',
        ];
    }
}

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the response as JSON
echo json_encode($response);
