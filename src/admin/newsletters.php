<?php
require_once 'config.php';

$response = $db->loginRequired();

if (!$response) {
    // If the user is not logged in, return an error message.
    $response = [
        'error' => 'Authentication required. Please log in.',
    ];
} else {
    // If the user is logged in, retrieve the list of newsletters.
    $newsletters = $db->query("SELECT * FROM newsletters ORDER BY id ASC");

    // Prepare the list of newsletters for the response.
    $newsletterList = [];
    foreach ($newsletters as $row) {
        $newsletterList[] = [
            'id' => $row['id'],
            'name' => $row['name'],
            'description' => $row['description'],
            'visible' => ($row['visible'] == "1") ? true : false,
        ];
    }

    // Construct the JSON response.
    $response = [
        'title' => 'Newsletters',
        'newsletters' => $newsletterList,
    ];
}

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the response as JSON
echo json_encode($response);
