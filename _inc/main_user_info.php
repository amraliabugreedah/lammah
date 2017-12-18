<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 12/18/2017
 * Time: 8:15 PM
 */


session_start();
if(!isset($_SESSION['logged_client'])){
    header("Location: ../_inc/login_form.php");
    exit;
}
$client_name = $_SESSION['logged_client'];
$sql = "SELECT cid FROM clients where clientname = '".$client_name." ' LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$curr_client_id = $row['cid'];
?>