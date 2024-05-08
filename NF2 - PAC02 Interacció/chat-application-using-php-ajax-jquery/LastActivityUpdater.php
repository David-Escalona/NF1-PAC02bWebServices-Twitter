// LastActivityUpdater.php

class LastActivityUpdater {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function updateLastActivity($loginDetailsId) {
        $query = "
            UPDATE login_details 
            SET last_activity = now() 
            WHERE login_details_id = :login_details_id
        ";

        $statement = $this->connection->prepare($query);
        $statement->bindParam(':login_details_id', $loginDetailsId, PDO::PARAM_INT);
        $statement->execute();
    }
}
