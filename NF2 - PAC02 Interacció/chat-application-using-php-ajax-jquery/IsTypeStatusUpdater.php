// IsTypeStatusUpdater.php

class IsTypeStatusUpdater {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function updateIsTypeStatus($isType, $loginDetailsId) {
        $query = "
            UPDATE login_details 
            SET is_type = :is_type 
            WHERE login_details_id = :login_details_id
        ";

        $statement = $this->connection->prepare($query);
        $statement->bindParam(':is_type', $isType, PDO::PARAM_STR);
        $statement->bindParam(':login_details_id', $loginDetailsId, PDO::PARAM_INT);
        $statement->execute();
    }
}
