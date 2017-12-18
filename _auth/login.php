<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 12/18/2017
 * Time: 11:31 AM
 */
include '../_lib/db.conf.php';
session_start();

if(isset($_POST['submitLoginInfo'])) {
    // username and password sent from form

    $myusername = mysqli_real_escape_string($conn,$_POST['username']);
    $mypassword = mysqli_real_escape_string($conn,$_POST['password']);

    $sql = "SELECT cid, clientpassword, active FROM client WHERE clientname = '$myusername'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $row_cnt = $result->num_rows;
    if($row_cnt == 1){
    $active = $row['active'];
    $validPassword = password_verify($mypassword, $row['clientpassword']);

        // If result matched $myusername and $mypassword, table row must be 1 row

        if($validPassword) {
            $_SESSION['logged_client'] = $myusername;
        }
        else {

            echo "<h2>Your Login Name or Password is invalid!</h2>";
        }
    }else {

        echo "<h2>Your Login Name or Password is invalid!</h2>";
    }
}
?>