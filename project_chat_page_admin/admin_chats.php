<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 1/4/2018
 * Time: 9:48 PM
 */
$pageTitle = 'Admin Chats';

$auth_users = array(1);

include '../_inc/header.php';
include '../_lib/db.conf.php';
include '../_inc/main_user_info.php';
include '../_inc/nav.php';

if(!in_array($curr_client_level, $auth_users)){
    header("Location: ../_inc/login_form.php");
    exit;
}


echo "<div class=\"wrapper\"> 
        <div class=\"container\">";

echo "</div></div>";
include '../_inc/footer.php';
mysqli_close($conn);
?>

<script>
    $('#adminChats').addClass("active");</script>
