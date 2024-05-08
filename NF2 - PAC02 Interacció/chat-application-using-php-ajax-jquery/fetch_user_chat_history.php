<?php

include('database_connection.php');
include('ChatHistoryOperations.php');

session_start();

$chatHistoryOperations = new ChatHistoryOperations($connect);

// Obtener el historial de chat entre los usuarios
$chatHistory = $chatHistoryOperations->fetchUserChatHistory($_SESSION['user_id'], $_POST['to_user_id']);

// Imprimir el historial de chat
echo $chatHistory; // Aquí ya estás imprimiendo el historial de chat directamente, ya que en el método fetchUserChatHistory se devuelve la cadena HTML completa

?>
