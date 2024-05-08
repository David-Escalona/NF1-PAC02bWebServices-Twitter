<?php

include('database_connection.php');
include('UserOperations.php');

session_start();

$userOperations = new UserOperations($connect);
$users = $userOperations->fetchAllUsersExceptCurrent($_SESSION['user_id']);

$output = '
<table class="table table-bordered table-striped">
    <tr>
        <th width="70%">Username</td>
        <th width="20%">Status</td>
        <th width="10%">Action</td>
    </tr>
';

foreach ($users as $user) {
    $status = '';
    $currentTimestamp = strtotime(date("Y-m-d H:i:s") . '- 10 second');
    $currentTimestamp = date('Y-m-d H:i:s', $currentTimestamp);
    $userLastActivity = $userOperations->getUserLastActivity($user['user_id']);
    if ($userLastActivity > $currentTimestamp) {
        $status = '<span class="label label-success">Online</span>';
    } else {
        $status = '<span class="label label-danger">Offline</span>';
    }
    $output .= '
    <tr>
        <td>'.$user['username'].' '.$userOperations->countUnseenMessages($user['user_id'], $_SESSION['user_id']).' '.$userOperations->fetchIsTypeStatus($user['user_id']).'</td>
        <td>'.$status.'</td>
        <td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="'.$user['user_id'].'" data-tousername="'.$user['username'].'">Start Chat</button></td>
    </tr>
    ';
}

$output .= '</table>';

echo $output;

?>
