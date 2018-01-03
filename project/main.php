<?php
$pageTitle = 'Main Page';

include '../_inc/header.php';
include '../_inc/nav.php';
include '../_lib/db.conf.php';
include '../_inc/main_user_info.php';

echo "<div class=\"wrapper\">
		<div class=\"container\">";

echo "<div class=\"table-responsive row topPayingUsers ourThemeBF\"  id=''>";
echo "<div class='col-sm-3'  align='left'>";
echo "<label style=' font-size: xx-large'>Top Paying Customers</label>";
echo "</div>";
echo "</div>";

include '../_inc/footer.php';
echo "</div></div>";
mysqli_close($conn);
?>

<script>
    $('#main').addClass("active");

    $(document).ready(function() {
        $.post("./getTopPayingUsers.php",
            {},
            function(data, status){
                if(status === "success"){
                    $('.topPayingUsers').append(data);
                }
            });
    });
</script>
