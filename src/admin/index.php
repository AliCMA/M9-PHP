<?php 

require_once './config.php'; 

$response = $db->loginRequired();

if (!$response) {

    header('Location: ./login.php');

    exit;

}

$users = $db->countQuery("SELECT COUNT(*) AS num FROM users");

$emails = $db->countQuery("SELECT COUNT(*) AS num FROM subscribers");

$subs = $db->countQuery("SELECT COUNT(*) AS num FROM subscriptions"); 

$nls = $db->countQuery("SELECT COUNT(*) AS num FROM newsletters");

$mess = $db->countQuery("SELECT COUNT(*) AS num FROM messages");

$temps = $db->countQuery("SELECT COUNT(*) AS num FROM templates");

$title = "Home"; 

$content = "<h3>current stats</h3>

<p>$users user registered</p>

<p>$emails subscribers</p>

<p>$subs newsletter subscriptions</p>

<p>$nls newsletters</p>

<p>$mess messages</p>

<p>$temps templates</p>"; 

include 'layout.php'; 

?>


// Parse the URL to extract the endpoint
$route = isset($_GET['route']) ? $_GET['route'] : '';

// Define response headers
header('Content-Type: application/json');

// Handle API routes
switch ($route) {
    case 'endpoint1':
        if ($method === 'GET') {
            // Handle GET request for endpoint1
            // Example: Retrieve data from the database
            $data = $db->query("SELECT * FROM your_table");
            echo json_encode($data);
        } elseif ($method === 'POST') {
            // Handle POST request for endpoint1
            // Example: Create a new record in the database
            // Make sure to validate and sanitize input data
            $postData = json_decode(file_get_contents('php://input'), true);
            // Perform database insert here
            echo json_encode(['message' => 'Record created']);
        }
        break;

    case 'endpoint2':
        if ($method === 'GET') {
            // Handle GET request for endpoint2
            // Example: Retrieve data from the database
            $data = $db->query("SELECT * FROM another_table");
            echo json_encode($data);
        }
        // Add more cases for other endpoints as needed

    default:
        // Handle invalid endpoints
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
        break;
}
