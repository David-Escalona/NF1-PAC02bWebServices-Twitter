// remove_chat.php

include('database_connection.php');
include('ChatMessageRemover.php');

if(isset($_POST["chat_message_id"]))
{
    $chatMessageRemover = new ChatMessageRemover($connect);
    $chatMessageRemover->removeChatMessage($_POST["chat_message_id"]);
}
