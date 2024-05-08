<?php

include('database_connection.php');
include('GroupChatOperations.php');

session_start();

$groupChatOperations = new GroupChatOperations($connect);

if ($_POST["action"] == "insert_data") {
    if ($groupChatOperations->insertChatMessage($_SESSION["user_id"], $_POST['chat_message'])) {
        echo $groupChatOperations->fetchGroupChatHistory();
    }
}

if ($_POST["action"] == "fetch_data") {
    echo $groupChatOperations->fetchGroupChatHistory();
}

?>
