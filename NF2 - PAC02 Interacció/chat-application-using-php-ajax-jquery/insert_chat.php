<?php

include('database_connection.php');
include('ChatAplication.php');

session_start();

$chatApp = new ChatApplication($connect);

echo $chatApp->insertChatMessage($_POST['to_user_id'], $_SESSION['user_id'], $_POST['chat_message']);

?>

