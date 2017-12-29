<?php
$pageTitle = 'Main Page';

include '../_inc/header.php';
include '../_inc/nav.php';
include '../_lib/db.conf.php';
include '../_inc/main_user_info.php';

echo "<div class=\"wrapper\">
		<div class=\"container\">";


include '../_inc/footer.php';
echo "</div></div>";
mysqli_close($conn);
?>

<script>
    $('#main').addClass("active");
</script>
