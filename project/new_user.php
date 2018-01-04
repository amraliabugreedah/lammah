<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 12/13/2017
 * Time: 8:11 PM
 */

$pageTitle = 'New User';
$auth_users = array(1,2);

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


if(!isset($_POST['addNewUser']) && $_SERVER['REQUEST_METHOD'] !== 'POST'){
echo "<div class=\"row\">";
echo " <form method=\"post\" action=\"order.php\">
  <div class=\"form-group\">
   <label for=\"first_name\">First Name: </label> 
   <input type=\"text\" required class=\"form-control\" id=\"first_name\" placeholder=\"Enter First Name\" name=\"first_name\">
   </div>
   <div class=\"form-group\">
    <label for=\"last_name\">Last Name:  </label> 
   <input type=\"text\" class=\"form-control\" id=\"last_name\" placeholder=\"Enter Last Name\" name=\"last_name\">
  </div>
  <div class=\"form-group\">
  <label for=\"mobile_no\"> Mobile Number: </label> 
    <input type=\"number\" required class=\"form-control input-medium bfh-phone\"  id=\"mobile_no\" placeholder=\"Enter Mobile Number\" name=\"mobile_no\">
  </div>
  <div class=\"form-group\">
  <label for=\"address\"> Address:   </label>    
   <input type=\"text\" required class=\"form-control\" id=\"address\" placeholder=\"Enter Address\" name=\"address\">
  </div>
  <input type=\"submit\"  class=\"btn btn-default\" style='pointer-events: none' disabled name=\"addNewUser\" id=\"addNewUser\" value=\"Submit\">
</form> ";

echo "</div>";
}

echo "</div></div>";
include '../_inc/footer.php';
mysqli_close($conn);
?>

<script>
    $('#newUser').addClass("active");

    $mobile_num = $('#mobile_no');
    $mobile_num.on('blur', function(){
        $mobile = $(this).val();
        $addNewUser = $('#addNewUser');
        $.post("../project_operations/check_user_email.php",
            {
                mobile_no: $mobile

            },
            function(data, status){
            if(data == false){
                $mobile_num.removeClass("alert-success");
                $mobile_num.addClass("alert-danger");
                $addNewUser.attr('disabled', true);
                $addNewUser.css('pointer-events', 'none');
            }else{
                $mobile_num.removeClass("alert-danger");
                $mobile_num.addClass("alert-success");
                $addNewUser.attr('disabled', false);
                $addNewUser.css('pointer-events', 'auto');
            }
            });
    });

</script>

