// update_is_type_status.php

include('database_connection.php');
include('IsTypeStatusUpdater.php');

session_start();

$isTypeStatusUpdater = new IsTypeStatusUpdater($connect);
$isTypeStatusUpdater->updateIsTypeStatus($_POST["is_type"], $_SESSION["login_details_id"]);
