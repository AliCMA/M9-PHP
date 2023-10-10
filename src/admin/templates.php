<?php
require_once 'config.php';

$response = $db->loginRequired();

if (!$response) {
    // If the user is not logged in, return an error message.
    $response = [
        'error' => 'Authentication required. Please log in.',
    ];
} else {
    // If the user is logged in, retrieve the list of templates.
    $templates = $db->query("SELECT * FROM templates ORDER BY id ASC");

    // Prepare the list of templates for the response.
    $templateList = [];
    foreach ($templates as $row) {
        $templateList[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'columns' => $row['columns'],
        ];
    }

    // Construct the JSON response.
    $response = [
        'title' => 'Templates',
        'templates' => $templateList,
    ];
}

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the response as JSON
echo json_encode($response);
