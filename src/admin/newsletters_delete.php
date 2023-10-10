<?php
require_once 'config.php';

$response = $db->loginRequired();

if (!$response) {
    // If the user is not logged in, return an error message.
    $response = [
        'error' => 'Authentication required. Please log in.',
    ];
} else {
    $id = (int)$_GET['id'];

    // Delete the newsletter from the database
    $db->deleteQuery('newsletters', $id);

    // Prepare a success message for the response
    $response = [
        'message' => 'Newsletter deleted successfully.',
    ];
}

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the response as JSON
echo json_encode($response);
