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
            echo "<h1> $mobile is already registered.<h1>";
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

            $order_id = isset($_GET['order_id'])?$_GET['order_id']:null;
            $ExpDeliveryDate = isset($_GET['ExpDeliveryDate'])?$_GET['ExpDeliveryDate']:null;
            if(isset($order_id)&&isset($ExpDeliveryDate)){
                $EDD = $ExpDeliveryDate;
                $sql1 = "UPDATE orders SET expected_delivery_time = '$EDD' WHERE  user_id = $row[id] AND id= $order_id";
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
                       <div class=\"col-sm-2\"> <label>Status:</label> </div>  <div class=\"col-sm-2\"><label> <img src=$statusIcon alt=$altStatus height=\"22\" width=\"22\"></label> </div>
                       </div>
                       <div class=\"row top-buffer\"> 
                       <div class=\"col-sm-2\"> <a href='./food.php?id=$row[id]&operation=NewOrder' type='button' class='btn btn-default'>New Order</a></div>
                       </div> 
                       <hr class=\"style1\">";

            $sql = "SELECT o.id, o.creation_time, o.expected_delivery_time, o.status, os.quantity, fi.item_name, fi.item_price FROM orders AS o INNER JOIN order_stuff AS os 
                    ON o.id = os.order_id INNER JOIN food_item AS fi ON fi.id = os.item_id WHERE os.user_id = $row[id] ORDER BY o.id DESC";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                $sql1 = "SELECT COUNT(*) AS total FROM order_stuff  WHERE order_id = $row[id]";
                $result1 = $conn->query($sql1);

            echo "<div class=\"row table-responsive\" align=\"center\" style=\"display: block;\" id=''>";
            echo "<table class=\"table table-hover table-bordered table-striped\">";
            echo " <thead>
      <tr>
        <th class=\"text-center\"></th>
        <th class=\"text-center\">Order ID</th>
        <th class=\"text-center\">Item Name</th>
        <th class=\"text-center\">Item Price</th>
        <th class=\"text-center\">Item Quantity</th>
        <th class=\"text-center\">Order Creation Time</th>
        <th class=\"text-center\">Order Status</th>
        <th class=\"text-center\">Expected Delivery Date</th>
      </tr>
    </thead>";
            echo "<tbody>";
                $row1 = $result1->fetch_assoc();
                $total_price = 0;
                $total_quantity = 0;
                for($i = 0; $i < $row1['total']; $i++) {
                    $total_price = $total_price + $row["item_price"];
                    $total_quantity = $total_quantity + $row["quantity"];
                    echo "<tr id=''>";
                    echo "  <td align='center' id=''></td>
                            <td align='center' id=''>" .$row['id'] . "</td>
                            <td align='center' id=''>" . $row["item_name"] . "</td>
                            <td align='center' id=''>" . $row["item_price"] . "</td>
                            <td align='center' id=''>" . $row["quantity"] . "</td>
                            <td align='center' id=''>" . $row["creation_time"] . "</td>";
                    if($row["status"] == 1){
                           echo "<td align='center' id=''>Delivered</td>";
                    }else if($row["status"] == 0){
                        echo "<td align='center' id=''>Order Not Delivered Yet</td>";
                    }else if($row["status"] == -1){
                        echo "<td align='center' id=''>Cancelled</td>";
                    }
                    echo "<td align='center' id=''>" . $row["expected_delivery_time"] . "</td>";
                                   echo "</tr>";
                    if($i < ($row1['total']-1)){
                        $row = $result->fetch_assoc();
                    }
                }
                echo "<tr id=''>";
                echo "  <td align='center' id=''>Total</td>
                            <td align='center' id=''></td>
                           <td align='center' id=''></td>
                            <td align='center' id=''>$total_price</td>
                            <td align='center' id=''>$total_quantity</td>
                            <td align='center' id=''></td>
                            <td align='center' id=''></td>
                                    </tr>";
            echo "</tbody>";
            echo " </table>";
            echo "</div>";
            }

        } else {
            echo "<h1>$mobile is not registered.<h1>";
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

