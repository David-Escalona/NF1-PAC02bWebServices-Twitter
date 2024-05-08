// RegistrationHandler.php

class RegistrationHandler {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function registerUser($username, $password, $confirmPassword) {
        $message = '';

        $check_query = "
            SELECT * FROM login 
            WHERE username = :username
        ";
        $statement = $this->connection->prepare($check_query);
        $check_data = array(
            ':username'     =>  $username
        );
        if($statement->execute($check_data)) {
            if($statement->rowCount() > 0) {
                $message .= '<p><label>Username already taken</label></p>';
            } else {
                if(empty($username)) {
                    $message .= '<p><label>Username is required</label></p>';
                }
                if(empty($password)) {
                    $message .= '<p><label>Password is required</label></p>';
                } else {
                    if($password != $confirmPassword) {
                        $message .= '<p><label>Password not match</label></p>';
                    }
                }
                if($message == '') {
                    $data = array(
                        ':username'     =>  $username,
                        ':password'     =>  password_hash($password, PASSWORD_DEFAULT)
                    );

                    $query = "
                        INSERT INTO login 
                        (username, password) 
                        VALUES (:username, :password)
                    ";
                    $statement = $this->connection->prepare($query);
                    if($statement->execute($data)) {
                        $message = "<label>Registration Completed</label>";
                    }
                }
            }
        }

        return $message;
    }
}
