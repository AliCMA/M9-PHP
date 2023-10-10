<?php
require_once 'config.php';

$response = $db->loginRequired();

if (!$response) {
    // If the user is not logged in, return an error response.
    $response = [
        'error' => 'Authentication required. Please log in.',
    ];
} else {
    $tab = 'sub';

    if (isset($_POST['submitted'])) {
        $id = (int)$_POST['id'];
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
        ];

        // Update subscriber data
        $db->updateQuery($data, $id, 'subscribers');

        foreach ($_POST['newsletter'] as $newsletterId => $subscriptionData) {
            $exists = $subscriptionData['exists'];
            $subscribe = $subscriptionData['subscribe'];

            if ($exists !== '1' && $subscribe === 'true') {
                // Subscribe the subscriber to the newsletter
                $data = [
                    'subscriber_id' => $id,
                    'newsletter_id' => $newsletterId,
                ];
                $db->insertQuery($data, 'subscriptions');
            } elseif ($exists === '1' && $subscribe !== 'true') {
                // Unsubscribe the subscriber from the newsletter
                $subid = (int)$subscriptionData['subid'];
                $db->deleteQuery('subscriptions', $subid);
            }
        }

        // Redirect or respond with a success message
        $response = [
            'message' => 'Subscriber edited successfully.',
        ];
    }
}

// Set the response content type to JSON
header('Content-Type: application/json');

// Output the response as JSON
echo json_encode($response);
