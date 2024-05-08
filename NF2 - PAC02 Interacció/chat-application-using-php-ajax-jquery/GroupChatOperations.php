<?php

class GroupChatOperations {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function insertChatMessage($fromUserId, $chatMessage) {
        try {
            $query = "INSERT INTO chat_message (from_user_id, to_user_id, chat_message, status) VALUES (:from_user_id, 0, :chat_message, '1')";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':from_user_id', $fromUserId, PDO::PARAM_INT);
            $statement->bindParam(':chat_message', $chatMessage, PDO::PARAM_STR);
            $result = $statement->execute();

            return $result;
        } catch (PDOException $e) {
            // Manejo de errores de PDO
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function fetchGroupChatHistory() {
        try {
            $query = "SELECT * FROM chat_message WHERE to_user_id = 0 ORDER BY timestamp DESC";
            $statement = $this->connection->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            $output = '<ul class="list-unstyled">';
            foreach ($result as $row) {
                $output .= '<li>' . $row['chat_message'] . '</li>';
            }
            $output .= '</ul>';

            return $output;
        } catch (PDOException $e) {
            // Manejo de errores de PDO
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}

?>

