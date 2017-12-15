<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 12/13/2017
 * Time: 8:11 PM
 */

$pageTitle = 'New User';

include '../_inc/header.php';
include '../_inc/nav.php';
include '../_lib/db.conf.php';

echo "<div class=\"container\">";
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
  <input type=\"submit\"  class=\"btn btn-default\" name=\"addNewUser\" id=\"addNewUser\" value=\"Submit\">
</form> ";

echo "</div>";
include '../_inc/footer.php';
?>

<script>
    $('#newUser').addClass("active");
</script>

