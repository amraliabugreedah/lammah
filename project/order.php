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


echo "<div class=\"container\">";
$mobile = isset($_POST['mobile_no'])?$_POST['mobile_no']:null;
$first_name = isset($_POST['first_name'])?$_POST['first_name']:null;
$last_name = isset($_POST['last_name'])?$_POST['last_name']:'';
$address = isset($_POST['address'])?$_POST['address']:null;

if(isset($_POST['addNewUser'])){
    $sql = "INSERT INTO users (client_id, first_name, last_name, mobile, address) values ($curr_client_id, '$first_name', '$last_name', '$mobile', '$address')";
    $conn->query($sql);
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

            $order_id = isset($_GET['order_id'])?$_GET['order_id']:null;
            $ExpDeliveryDate = isset($_GET['ExpDeliveryDate'])?$_GET['ExpDeliveryDate']:null;
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
                $statusIcon = '../images/Warning.png';
                $altStatus = "Warning";
            }

            $sql2 = "SELECT COUNT(DISTINCT o.id) AS total FROM orders AS o INNER JOIN order_stuff AS os 
                    ON o.id = os.order_id INNER JOIN food_item AS fi ON fi.id = os.item_id WHERE os.user_id = $row[id] AND client_id = $curr_client_id";
            $result2 = $conn->query($sql2);
            $row2 = $result2->fetch_assoc();

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
                       <div class=\"col-sm-2\"> <label>Mobile:</label> </div>  <div class=\"col-sm-2\"><label> " . $row["mobile"] . "</label> </div>
                       </div>
                       <div class=\"row bg-1 top-buffer2\"> 
                       <div class=\"col-sm-2\"> <label>Address:</label> </div>  <div class=\"col-sm-2\"><label> " . $row["address"] . "</label> </div>
                       </div>
                       <div class=\"row bg-1 top-buffer2\"> 
                       <div class=\"col-sm-2\"> <label>Number Of Orders:</label> </div>  <div class=\"col-sm-2\"><label> " . $row2["total"] . "</label> </div>
                       </div>
                       <div class=\"row bg-1 top-buffer2\"> 
                       <div class=\"col-sm-2\"> <label>Status:</label> </div>  <div class=\"col-sm-2\"><label> <img src=$statusIcon alt=$altStatus height=\"22\" width=\"22\"></label> </div>
                       </div>
                       <div class=\"row top-buffer\"> 
                       <div class=\"col-sm-2\"> <a href='./food.php?id=$row[id]&operation=NewOrder' type='button' class='btn btn-default'>New Order</a></div>
                       </div> 
                       <hr class=\"style1\">";

                        echo "<script>var id = $row[id];</script>";
                        echo "<script>var disableUpperFuntion = false;</script>";

                        echo "<div class='userOrders'></div>";


            echo "<script>var orders_num = $row2[total];</script>";
                        echo "<div class='' align='center'>
                            <ul class=\"pagination\">
                            
                            </ul></div>";


        } else {
            echo "<h1>$mobile is not registered.<h1>";
        }

    }



echo "</div>";
mysqli_close($conn);
include '../_inc/footer.php';
?>

<script>
    $('#order').addClass("active");

    if(disableUpperFuntion === false){
        console.log("fuck");
    $(function(){
        console.log(id);
        console.log(orders_num);
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
                $('.pagination').append(' <li id ="1"><a class="pageNum">1</a></li>');
                for($i = 1; $i<$num_pages; $i++){
                    $('.pagination').append(' <li id ='+($i+1)+'><a class=\'pageNum\'>'+($i+1)+'</a></li>');
                }
                console.log(status);
                disableUpperFuntion = true;
            });
    });
    }
    $(document).on('click', '.pageNum', function(e) {
        disableUpperFuntion = true;
        $page_num = $(this).parent().attr('id');
        console.log($page_num);
        console.log(id);
        console.log(orders_num);
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
                $('.pagination').empty();
                $('.pagination').append(' <li id ="1"><a class="pageNum">1</a></li>');
                for($i = 1; $i<$num_pages; $i++){
                    $('.pagination').append(' <li id ='+($i+1)+'><a class=\'pageNum\'>'+($i+1)+'</a></li>');
                }
                console.log(status);
            });
    });







</script>

