<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 12/13/2017
 * Time: 8:11 PM
 */

$pageTitle = 'Users';

include '../_inc/header.php';
include '../_inc/nav.php';
include '../_lib/db.conf.php';
include '../_inc/main_user_info.php';



mysqli_close($conn);
include '../_inc/footer.php';
?>

<script>
    $('#users').addClass("active");
</script>

