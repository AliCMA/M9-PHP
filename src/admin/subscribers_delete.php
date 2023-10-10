<?php
require_once 'config.php';

$response = $db->loginRequired();

if (!$response) {
    // If the user is not logged in, return an error response.
    $response = [
        'error' => 'Authentication required. Please log in.',
    ];
} else {
    $id = (int)$_GET['id'];

    // Delete the subscriber from the database
    $stmt = $db->deleteQuery('subscribers', $id);

    if ($stmt) {
        $response = [
            'message' => 'Subscriber deleted successfully.',
        ];
    } else {
        $response = [
            'error' => 'Failed to delete the subscriber.',
        ];
    }
}

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the response as JSON
echo json_encode($response);
