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
include '../_inc/main_user_info.php';


echo "<div class=\"wrapper\"> 
        <div class=\"container\">";
$mobile = isset($_POST['mobile_no'])?$_POST['mobile_no']:null;
if(!isset($mobile)){$mobile = isset($_GET['mobile_no'])?$_GET['mobile_no']:null;}
$first_name = isset($_POST['first_name'])?$_POST['first_name']:null;
$last_name = isset($_POST['last_name'])?$_POST['last_name']:null;
$address = isset($_POST['address'])?$_POST['address']:null;
$status_num = isset($_POST['status_num'])?$_POST['status_num']:null;
$user_id = isset($_POST['user_id'])?$_POST['user_id']:null;

if(isset($_POST['addNewUser'])){
    $sql = "INSERT INTO users (client_id, first_name, last_name, mobile, address) values ($curr_client_id, '$first_name', '$last_name', '$mobile', '$address')";
    $conn->query($sql);
}

if(isset($status_num)){
    $sql = "UPDATE users SET status = $status_num WHERE id = $user_id";
    $conn->query($sql);
    echo  $sql;
    exit;
}

    if(!isset($_POST['getUser']) && !isset($mobile)){

        echo " <form method=\"post\" action=\"order.php\">
  <div class=\"form-group\">
   <label for=\"mobile_no\">Search </label> 
   <input type=\"number\" required class=\"form-control\" id=\"mobile_no\" placeholder=\"Enter Mobile Number\" name=\"mobile_no\">
   </div>
  <input type=\"submit\"  class=\"btn btn-default\" name=\"getUser\" id=\"getUser\" value=\"Submit\">
</form> ";


    }else{


        $sql = "SELECT * FROM users WHERE mobile = '$mobile' AND client_id = $curr_client_id";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            // output data of each row
            $row = $result->fetch_assoc();

            $order_id = isset($_POST['order_id'])?$_POST['order_id']:null;
            $ExpDeliveryDate = isset($_POST['ExpDeliveryDate'])?$_POST['ExpDeliveryDate']:null;
            if(isset($order_id)&&isset($ExpDeliveryDate)){
                $EDD = $ExpDeliveryDate;
                $sql1 = "UPDATE orders SET expected_delivery_time = '$EDD' WHERE  user_id = $row[id] AND id= $order_id AND client_id = $curr_client_id";
                $conn->query($sql1);

            }

            if($row['status'] == 0){
                $statusIcon = '../images/alert.ico';
                $altStatus = "Alert";
            }else if($row['status'] == 1){
                $statusIcon = '../images/ok.ico';
                $altStatus = "Ok";
            }else if($row['status'] == -1){
                $statusIcon = '../images/warning.png';
                $altStatus = "Warning";
            }

            $sql2 = "SELECT COUNT(DISTINCT o.id) AS total, SUM(fi.item_price) AS total_paid FROM orders AS o INNER JOIN order_stuff AS os 
                    ON o.id = os.order_id INNER JOIN food_item AS fi ON fi.id = os.item_id WHERE os.user_id = $row[id] AND client_id = $curr_client_id";
            $result2 = $conn->query($sql2);
            $row2 = $result2->fetch_assoc();

                echo "<div class=\"row\"> <div class=\"row bg-1 top-buffer2\"> 
                     <div class=\"col-sm-2\"> <label>ID:</label> </div>  <div class=\"col-sm-2\"><label>" . $row["id"]. " </label></div>
                     </div>
                     <div class=\"row bg-1 top-buffer2\"> 
                      <div class=\"col-sm-2\"> <label> First Name:</label> </div>  <div class=\"col-sm-2\"><label> " . $row["first_name"]. "</label> </div>
                      </div>
                        <div class=\"row bg-1 top-buffer2\"> 
                       <div class=\"col-sm-2\"> <label>Last Name:</label> </div>  <div class=\"col-sm-2\"><label> " . $row["last_name"]. "</label> </div>
                       </div>
                       <div class=\"row bg-1 top-buffer2\"> 
                       <div class=\"col-sm-2\"> <label>Mobile:</label> </div>  <div class=\"col-sm-2\"><label> " . $row["mobile"] . "</label> </div>
                       </div>
                       <div class=\"row bg-1 top-buffer2\"> 
                       <div class=\"col-sm-2\"> <label>Address:</label> </div>  <div class=\"col-sm-2\"><label> " . $row["address"] . "</label> </div>
                       </div>
                       <div class=\"row bg-1 top-buffer2\"> 
                       <div class=\"col-sm-2\"> <label>Number Of Orders:</label> </div>  <div class=\"col-sm-2\"><label> " . $row2["total"] . "</label> </div>
                       </div> 
                       <div class=\"row bg-1 top-buffer2\"> 
                       <div class=\"col-sm-2\"> <label>Total Paid:</label> </div>  <div class=\"col-sm-2\"><label> " . $row2["total_paid"] . " EGP</label> </div>
                       </div>
                       <div class=\"row bg-1 top-buffer2\"> 
                       <div class=\"col-sm-2\"> <label>Status:</label> </div>  <div class=\"col-sm-2\"><label>
                        
                            <div class=\"dropdown\">
                              <a class=\"dropbtn\"> <img src=$statusIcon alt=$altStatus height=\"22\" width=\"22\"></a>
                              <div class=\"dropdown-content\" >
                                <a href=\"#\" class='status_img'><img src='../images/alert.ico' id='$row[id]' alt='Alert' height=\"22\" width=\"22\"></a>
                                <a href=\"#\" class='status_img'><img src='../images/ok.ico' id='$row[id]' alt='Ok' height=\"22\" width=\"22\"></a>
                                <a href=\"#\" class='status_img'><img src='../images/warning.png' id='$row[id]' alt='Warning' height=\"22\" width=\"22\"></a>
                              </div>
                            </div>                          
                        </label> </div>
                       
                       </div>
                       <div class=\"row top-buffer\"> 
                       <form method=\"post\" action=\"products.php\">
                       <input hidden type='text' id='user_id' name='user_id' value='$row[id]'>
                       <div class=\"col-sm-2\"> <input id = 'NewOrder' name='NewOrder' type='submit' class='btn btn-default' value='New Order'></div>
                       </form>
                       </div> 
                       <hr class=\"style1\">";

                        echo "<script>let id = $row[id];</script>";
                        echo "<script>let disableUpperFuntion = false;</script>";

                        echo "<div class='userOrders'></div>";


            echo "<script>var orders_num = $row2[total];</script>";
                        echo "<div class='' align='center'>
                            <ul class=\"pagination\">
                            
                            </ul></div>";


        } else {
            echo "<h1>$mobile is not registered.<h1>";
        }

    }



include '../_inc/footer.php';
echo "</div></div>";

mysqli_close($conn);
?>

<script>
    $('#order').addClass("active");

    if(disableUpperFuntion === false){
    $(function(){
        $.post("./get_user_orders.php",
            {
                user_id: id,
                orders_num: orders_num,
                page_num: 1
            },
            function(data, status){
                $userOrdersDiv = $('.userOrders');
                $userOrdersDiv.empty();
                $userOrdersDiv.append(data);
                $('.pagination').empty();
                $num_pages = orders_num/4;
                $('.pagination').append(' <li class="active" id ="1"><a class="pageNum">1</a></li>');
                for($i = 1; $i<$num_pages; $i++){
                    $('.pagination').append(' <li id ='+($i+1)+'><a class=\'pageNum\'>'+($i+1)+'</a></li>');
                }
                disableUpperFuntion = true;
            });
    });
    }
    $(document).on('click', '.pageNum', function(e) {
        disableUpperFuntion = true;
        $page_num = $(this).parent().attr('id');
        $.post("./get_user_orders.php",
            {
                user_id: id,
                orders_num: orders_num,
                page_num: $page_num
            },
            function(data, status){
                $userOrdersDiv = $('.userOrders');
                $userOrdersDiv.empty();
                $userOrdersDiv.append(data);
                $num_pages = orders_num/4;
                $pagination = $('.pagination');
                $pagination.empty();
                for($i = 0; $i<$num_pages; $i++){
                    if(($i+1)==$page_num){
                        $pagination.append(' <li class="active" id ='+($i+1)+'><a class=\'pageNum\'>'+($i+1)+'</a></li>');
                    }else{
                        $pagination.append(' <li id ='+($i+1)+'><a class=\'pageNum\'>'+($i+1)+'</a></li>');
                    }
                }
            });
    });

 $('.status_img').on('click', function(){
     $status_img_url = $(this).find('img').attr('src');

     if($status_img_url === '../images/alert.ico'){
         $status_num = 0;
     }else if($status_img_url === '../images/ok.ico'){
         $status_num = 1;
     }else{
         $status_num = -1;
     }
     $user_id = $(this).find('img').attr('id');
     $.post("./order.php",
         {
             status_num: $status_num,
             user_id: $user_id
         },
         function(data, status){
         if(status === "success"){
             $('.dropbtn').find('img').attr('src', $status_img_url);
         }
         });
 });





</script>

