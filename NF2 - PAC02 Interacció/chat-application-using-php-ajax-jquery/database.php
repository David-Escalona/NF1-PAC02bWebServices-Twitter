<!-- database.php -->
<?php

class Database {
    private $dsn;
    private $username;
    private $password;
    private $connection;

    public function __construct($dsn, $username, $password) {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->connect();
    }

    private function connect() {
        try {
            $this->connection = new PDO($this->dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function fetchUserLastActivity($userId) {
        $query = "SELECT * FROM login_details WHERE user_id = :user_id ORDER BY last_activity DESC LIMIT 1";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchUserChatHistory($fromUserId, $toUserId) {
        $query = "SELECT * FROM chat_message WHERE (from_user_id = :from_user_id AND to_user_id = :to_user_id) OR (from_user_id = :to_user_id AND to_user_id = :from_user_id) ORDER BY timestamp DESC";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':from_user_id', $fromUserId, PDO::PARAM_INT);
        $statement->bindParam(':to_user_id', $toUserId, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Otros métodos para las demás operaciones CRUD...
}

?>
