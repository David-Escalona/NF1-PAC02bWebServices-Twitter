<?php

class ChatMessageRemover {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function removeChatMessage($chatMessageId) {
        try {
            $query = "DELETE FROM chat_message WHERE chat_message_id = :chat_message_id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':chat_message_id', $chatMessageId, PDO::PARAM_INT);
            $result = $statement->execute();

            return $result;
        } catch (PDOException $e) {
            // Manejo de errores de PDO
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}

?>


