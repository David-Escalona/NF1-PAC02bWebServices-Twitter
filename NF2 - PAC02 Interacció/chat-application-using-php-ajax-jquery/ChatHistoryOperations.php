<?php

class ChatHistoryOperations {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function fetchUserChatHistory($fromUserId, $toUserId) {
        try {
            $query = "
            SELECT * FROM chat_message 
            WHERE (from_user_id = :from_user_id AND to_user_id = :to_user_id) 
            OR (from_user_id = :to_user_id AND to_user_id = :from_user_id) 
            ORDER BY timestamp DESC
            ";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':from_user_id', $fromUserId, PDO::PARAM_INT);
            $statement->bindParam(':to_user_id', $toUserId, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            // Construir el HTML para mostrar los mensajes
            $chatHistoryHtml = '<ul class="chat-history">';
            foreach ($result as $message) {
                // Determinar la clase CSS basada en el remitente del mensaje
                $messageClass = ($message['from_user_id'] == $fromUserId) ? 'sent' : 'received';

                // Construir el elemento de lista HTML para el mensaje
                $chatHistoryHtml .= '<li class="' . $messageClass . '">' . $message['chat_message'] . '</li>';
            }
            $chatHistoryHtml .= '</ul>';

            // Devolver el HTML del historial de chat
            return $chatHistoryHtml;
        } catch (PDOException $e) {
            // Manejar cualquier error que ocurra durante la consulta
            echo "Error fetching chat history: " . $e->getMessage();
            return false;
        }
    }
}

?>

