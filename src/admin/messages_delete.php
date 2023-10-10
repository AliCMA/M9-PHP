<?php 

require_once 'config.php'; 

$response = $db->loginRequired();

if (!$response) {

    header('Location: login.php');

    exit;

}

$id = (int) $_GET['id'];

$db->deleteQuery("messages", $id);

$_SESSION['success'] = "Message deleted."; 

header('Location: messages.php'); 

?>
