<?php
$pageTitle = 'Main Page';

include '../_inc/header.php';
include '../_inc/nav.php';
include '../_lib/db.conf.php';
include '../_inc/main_user_info.php';

echo "<div class=\"wrapper\">
		<div class=\"container\">";

echo "<div class=\"table-responsive row topPayingUsers \"  id=''>";
echo "<div class='col-sm-3 ourThemeBF'  align='left'>";
echo "<label class='tableLabel'>Top Paying Customers</label>";
echo "</div>";
echo "</div>";

echo "<div class=\"table-responsive row topOrderedItems top-buffer\"  id=''>";
echo "<div class='col-sm-3 ourThemeBF'  align='left'>";
echo "<label class='tableLabel'>Top Ordered Items</label>";
echo "</div>";
echo "</div>";

echo "</div></div>";
include '../_inc/footer.php';
mysqli_close($conn);
?>

<script>
    $('#main').addClass("active");

    $(document).ready(function() {
        $.post("../project_operations/getTopPayingUsers.php",
            {},
            function(data, status){
                if(status === "success"){
                    $('.topPayingUsers').append(data);
                }
            });
        $.post("../project_operations/getTopOrderedItems.php",
            {},
            function(data, status){
                if(status === "success"){
                    $('.topOrderedItems').append(data);
                }
            });
    });
</script>
