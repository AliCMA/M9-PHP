<?php 

require_once 'config.php'; 

$response = $db->loginRequired();

if (!$response) {

    header('Location: login.php');

    exit;

}

$title = "New Message - Step 3";

$id = (int) $_GET['id'];

$tab = 'mess'; 

$mess = $db->query("SELECT * FROM messages WHERE id=$id");

$message = $mess[0];

$subject = $message['subject'];

$content = '<a href="messages_preview.php?id=$id" class="large" target="_new">preview »</a><br />

<p>Do you want to <a href="messages.php" class="large">return to messages</a> or <a href="messages_send.php?id=$id" class="large">send the message</a>?</p>';

include 'layout.php'; 

?>