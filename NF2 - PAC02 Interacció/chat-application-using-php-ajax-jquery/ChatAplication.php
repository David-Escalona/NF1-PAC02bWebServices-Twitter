<?php

class ChatApplication {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function fetchUser() {
        try {
            // Query para seleccionar usuarios en línea
            $query = "SELECT * FROM users WHERE online_status = 1";
            
            // Preparar la consulta
            $statement = $this->connection->prepare($query);
            
            // Ejecutar la consulta
            $statement->execute();
            
            // Obtener los resultados
            $users = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            // Retornar los usuarios encontrados
            return $users;
        } catch (PDOException $e) {
            // Manejar cualquier error que ocurra durante la consulta
            echo "Error fetching online users: " . $e->getMessage();
            return false;
        }
    }

    public function updateLastActivity($userId) {
        try {
            // Obtener la hora actual
            $currentTime = date('Y-m-d H:i:s');

            // Query para actualizar la última actividad del usuario
            $query = "UPDATE users SET last_activity = :last_activity WHERE id = :user_id";

            // Preparar la consulta
            $statement = $this->connection->prepare($query);

            // Vincular los parámetros
            $statement->bindParam(':last_activity', $currentTime, PDO::PARAM_STR);
            $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);

            // Ejecutar la consulta
            $statement->execute();

            // Verificar si se actualizó correctamente
            if ($statement->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Manejar cualquier error que ocurra durante la consulta
            echo "Error updating last activity: " . $e->getMessage();
            return false;
        }
    }

    public function makeChatDialogBox($toUserId, $toUserName) {
        // Crear el HTML para el cuadro de diálogo de chat
        $dialogBox = '<div class="chat-dialog-box">';
        $dialogBox .= '<h4>Chat with '.$toUserName.'</h4>';
        $dialogBox .= '<div class="chat-messages" id="chat-messages-'.$toUserId.'">';
        // Aquí puedes cargar el historial de chat previo si lo deseas
        $dialogBox .= '</div>';
        $dialogBox .= '<textarea class="chat-input" id="chat-input-'.$toUserId.'" placeholder="Type your message..."></textarea>';
        $dialogBox .= '<button class="send-message-btn" data-to-user-id="'.$toUserId.'">Send</button>';
        $dialogBox .= '</div>';

        // Devolver el HTML del cuadro de diálogo de chat
        return $dialogBox;
    }

    public function fetchUserChatHistory($toUserId) {
        try {
            // Consulta SQL para obtener el historial de chat con un usuario específico
            $query = "SELECT * FROM chat_message WHERE (from_user_id = :from_user_id AND to_user_id = :to_user_id) OR (from_user_id = :to_user_id AND to_user_id = :from_user_id) ORDER BY timestamp DESC";
            
            // Preparar la consulta
            $statement = $this->connection->prepare($query);
            
            // Vincular los parámetros
            $statement->bindParam(':from_user_id', $_SESSION['user_id'], PDO::PARAM_INT);
            $statement->bindParam(':to_user_id', $toUserId, PDO::PARAM_INT);
            
            // Ejecutar la consulta
            $statement->execute();
            
            // Obtener los resultados
            $chatHistory = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            // Devolver el historial de chat
            return $chatHistory;
        } catch (PDOException $e) {
            // Manejar errores si ocurre alguna excepción
            echo "Error fetching chat history: " . $e->getMessage();
            return false;
        }
    }

    public function insertChatMessage($toUserId, $fromUserId, $chatMessage) {
        try {
            $status = 1; // Puedes ajustar el valor de status según sea necesario
            $query = "INSERT INTO chat_message (from_user_id, to_user_id, chat_message, timestamp, status) VALUES (:from_user_id, :to_user_id, :chat_message, NOW(), :status)";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':from_user_id', $fromUserId, PDO::PARAM_INT);
            $statement->bindParam(':to_user_id', $toUserId, PDO::PARAM_INT);
            $statement->bindParam(':chat_message', $chatMessage, PDO::PARAM_STR);
            $statement->bindParam(':status', $status, PDO::PARAM_INT); // Bind the status parameter
            $result = $statement->execute();

            if ($result) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Manejo de errores
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}

?>


