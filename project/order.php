<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 12/13/2017
 * Time: 8:11 PM
 */

$pageTitle = 'Order';

include '../_inc/header.php';
include '../_inc/nav.php';
include '../_lib/db.conf.php';
echo "<div class=\"container\">";
if(isset($_POST['addNewUser'])){
    $first_name = $_POST['first_name'];
    $last_name = isset($_POST['last_name'])?$_POST['last_name']:'';
    $mobile = $_POST['mobile_no'];
    $address = $_POST['address'];

    $sql = "INSERT INTO users (first_name, last_name, mobile, address) values (\"$first_name\", \"$last_name\", $mobile, \"$address\")";

    if (!mysqli_query($conn, $sql)) {
        $error = substr(mysqli_error($conn), 0, 9);
        if($error == "Duplicate"){
            echo "<h1>This mobile number is already registered.<h1>";
        }else{
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }else{
        header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . "/project/order.php?mobile_no=$mobile");
    }

}else{
    $mobile = isset($_GET['mobile_no'])?$_GET['mobile_no']:null;
    if(!isset($_POST['getUser']) && !isset($mobile)){

        echo " <form method=\"GET\" action=\"order.php\">
  <div class=\"form-group\">
   <label for=\"mobile_no\">Search </label> 
   <input type=\"number\" required class=\"form-control\" id=\"mobile_no\" placeholder=\"Enter Mobile Number\" name=\"mobile_no\">
   </div>
  <input type=\"submit\"  class=\"btn btn-default\" name=\"getUser\" id=\"getUser\" value=\"Submit\">
</form> ";


    }else{


        $sql = "SELECT * FROM users WHERE mobile = $mobile";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // output data of each row
            $row = $result->fetch_assoc();
            if($row['status'] == 0){
                $statusIcon = '../images/Kyo-Tux-Aeon-Sign-Alert.ico';
                $altStatus = "Alert";
            }else if($row['status'] == 1){
                $statusIcon = '../images/Tatice-Cristal-Intense-Ok.ico';
                $altStatus = "Ok";
            }else if($row['status'] == -1){
                $statusIcon = '../images/Warning.png';
                $altStatus = "Warning";
            }
                echo "<div class=\"row bg-1 top-buffer2\"> 
                     <div class=\"col-sm-2\"> <label>ID:</label> </div>  <div class=\"col-sm-2\"><label>" . $row["id"]. " </label></div>
                     </div>
                     <div class=\"row bg-1 top-buffer2\"> 
                      <div class=\"col-sm-2\"> <label> First Name:</label> </div>  <div class=\"col-sm-2\"><label> " . $row["first_name"]. "</label> </div>
                      </div>
                        <div class=\"row bg-1 top-buffer2\"> 
                       <div class=\"col-sm-2\"> <label>Last Name:</label> </div>  <div class=\"col-sm-2\"><label> " . $row["last_name"]. "</label> </div>
                       </div>
                       <div class=\"row bg-1 top-buffer2\"> 
                       <div class=\"col-sm-2\"> <label>Mobile:</label> </div>  <div class=\"col-sm-2\"><label> " . $row["mobile"]. "</label> </div>
                       </div>
                       <div class=\"row bg-1 top-buffer2\"> 
                       <div class=\"col-sm-2\"> <label>Address:</label> </div>  <div class=\"col-sm-2\"><label> " . $row["address"]. "</label> </div>
                       </div>
                       <div class=\"row bg-1 top-buffer2\"> 
                       <div class=\"col-sm-2\"> <label>Status:</label> </div>  <div class=\"col-sm-2\"><label> <img src=$statusIcon alt=$altStatus height=\"22\" width=\"22\"></label> </div>
                       </div>
                       <div class=\"row top-buffer\"> 
                       <div class=\"col-sm-2\"> <a href='./food.php?id=$row[id]&operation=NewOrder' type='button' class='btn btn-default'>New Order</a></div>
                       </div>";

        }else{
            echo "<h1>This mobile number is not registered.<h1>";
        }

    }
}


echo "</div>";
mysqli_close($conn);
include '../_inc/footer.php';
?>

<script>
    $('#order').addClass("active");
</script>

