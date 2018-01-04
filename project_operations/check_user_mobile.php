<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 12/20/2017
 * Time: 11:28 PM
 */
include '../_lib/db.conf.php';
include '../_inc/main_user_info.php';

$mobile = isset($_POST['mobile_no'])?$_POST['mobile_no']:null;

$sql = "SELECT mobile FROM users WHERE mobile = '$mobile' AND client_id = $curr_client_id";

$result = $conn->query($sql);
$row_cnt = $result->num_rows;
if($row_cnt === 1){
    echo false;
}else{
    echo true;
}
?>