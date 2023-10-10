<?php
// Set the response content type to JSON
header('Content-Type: application/json');

// Define your response data
$response = [
    'title' => $title,
    'content' => $content,
];

// Output the JSON response
echo json_encode($response);
