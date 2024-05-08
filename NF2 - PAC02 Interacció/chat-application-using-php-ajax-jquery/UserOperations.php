<?php

class UserOperations {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function fetchAllUsersExceptCurrent($currentUserId) {
        $query = "SELECT * FROM login WHERE user_id != :user_id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':user_id', $currentUserId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserLastActivity($userId) {
        // Implementar esta función si es necesario
    }

    public function countUnseenMessages($fromUserId, $toUserId) {
        // Implementar esta función si es necesario
    }

    public function fetchIsTypeStatus($userId) {
        // Implementar esta función si es necesario
    }
}

?>
