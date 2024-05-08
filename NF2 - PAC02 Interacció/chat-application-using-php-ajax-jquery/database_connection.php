<?php

// database_connection.php

$dsn = "pgsql:host=localhost;port=5432;dbname=chat";
$username = "postgres";
$password = "root";

date_default_timezone_set('Asia/Kolkata');

try {
    $connect = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

class DatabaseConnection {
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

    public function getConnection() {
        return $this->connection;
    }
}

class DatabaseOperations {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function fetchUserLastActivity($user_id) {
        $query = "SELECT * FROM login_details WHERE user_id = :user_id ORDER BY last_activity DESC LIMIT 1";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchUserChatHistory($from_user_id, $to_user_id) {
        $query = "SELECT * FROM chat_message WHERE (from_user_id = :from_user_id AND to_user_id = :to_user_id) OR (from_user_id = :to_user_id AND to_user_id = :from_user_id) ORDER BY timestamp DESC";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':from_user_id', $from_user_id, PDO::PARAM_INT);
        $statement->bindParam(':to_user_id', $to_user_id, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Otras operaciones CRUD...
}

?>

