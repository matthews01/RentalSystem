<?php
session_start();

if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

include "config/config.php";

// Ensure the required POST variables are set
if (isset($_POST['message'], $_POST['owner_id'], $_POST['tenant_id'])) {
    $u_email = $_SESSION["email"];
    $message = trim($_POST['message']);
    $owner_id = $_POST['owner_id'];
    $tenant_id = $_POST['tenant_id'];

    // Ensure the message is not empty
    if (!empty($message)) {
        // Insert the message into the chat table
        $sql = "INSERT INTO chat (message, owner_id, tenant_id) VALUES ('$message', '$owner_id', '$tenant_id')";
        $query = mysqli_query($db, $sql);

        if ($query) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            echo "Something went wrong with the query.";
        }
    } else {
        echo "Message cannot be empty.";
    }
} 
?>
