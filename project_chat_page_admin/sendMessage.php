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

$sql = "SELECT chat_id FROM client_chats WHERE client_id = 2 LIMIT 1";
$result = $conn->query($sql);
if($result->num_rows == 1){
$row = $result->fetch_assoc();
$chat_id = $row['chat_id'];
if(!empty($message)){
$sql = "INSERT INTO chat_records (chat_id, from_client_id, to_client_id, message) VALUES ($chat_id, 1, 2, '$message')";
    $conn->query($sql);
}else{
    echo "Empty Message!";
}
}
mysqli_close($conn);
?>