<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 1/4/2018
 * Time: 1:09 AM
 */
include '../_lib/db.conf.php';
include '../_inc/main_user_info.php';

$message = isset($_POST['message'])?$_POST['message']:'';
$chat_id = isset($_POST['chat_id'])?$_POST['chat_id']:null;

$sql = "SELECT client_id FROM client_chats WHERE chat_id = $chat_id LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$client_id = $row['client_id'];

if(!empty($message)){
$sql = "INSERT INTO chat_records (chat_id, from_client_id, to_client_id, message) VALUES ($chat_id, 1, $client_id, '$message')";
    $conn->query($sql);
}else{
    echo "Empty Message!";
}

mysqli_close($conn);
?>