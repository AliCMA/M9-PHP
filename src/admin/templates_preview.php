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

    // Retrieve the body of the template by ID
    $data = $db->query("SELECT body FROM templates WHERE id={$id} LIMIT 1");
    
    if (!empty($data)) {
        $template = $data[0]['body'];
        $response = [
            'template' => $template,
        ];
    } else {
        // If the template ID does not exist, return an error message.
        $response = [
            'error' => 'Template not found.',
        ];
    }
}

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the response as JSON
echo json_encode($response);
