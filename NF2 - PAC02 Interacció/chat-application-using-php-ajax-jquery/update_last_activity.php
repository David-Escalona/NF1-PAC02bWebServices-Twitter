// update_last_activity.php

include('database_connection.php');
include('LastActivityUpdater.php');

session_start();

$lastActivityUpdater = new LastActivityUpdater($connect);
$lastActivityUpdater->updateLastActivity($_SESSION["login_details_id"]);


