<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 12/19/2017
 * Time: 10:04 PM
 */

include '../_lib/db.conf.php';
include '../_inc/main_user_info.php';

$id = isset($_POST['user_id'])?$_POST['user_id']:null;
$orders_num = isset($_POST['orders_num'])?$_POST['orders_num']:null;
$page_num = isset($_POST['page_num'])?$_POST['page_num']:null;
$startRow = ($page_num-1)*4;

if($orders_num < 5){
    $sql = "SELECT o.id, o.creation_time, o.expected_delivery_time, o.status, os.quantity, fi.item_name, fi.item_price FROM orders AS o INNER JOIN order_stuff AS os 
                    ON o.id = os.order_id INNER JOIN food_item AS fi ON fi.id = os.item_id WHERE os.user_id = $id AND client_id = $curr_client_id ORDER BY o.expected_delivery_time ASC";
}else{
    $sql = "SELECT o.id, o.creation_time, o.expected_delivery_time, o.status, os.quantity, fi.item_name, fi.item_price FROM orders AS o INNER JOIN order_stuff AS os 
                    ON o.id = os.order_id INNER JOIN food_item AS fi ON fi.id = os.item_id WHERE os.user_id = $id AND client_id = $curr_client_id ORDER BY o.expected_delivery_time ASC LIMIT $startRow,4";
}

$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
    $sql1 = "SELECT COUNT(*) AS total FROM order_stuff  WHERE order_id = $row[id]";
    $result1 = $conn->query($sql1);

    echo "<div class=\"row table-responsive\" align=\"center\" style=\"display: block;\" id=''>";
    echo "<table class=\"table table-hover table-bordered table-striped\">";
    echo " <thead>
      <tr>
        <th class=\"text-center\" style='width: 2%'></th>
        <th class=\"text-center\" style='width: 8%'>Order ID</th>
        <th class=\"text-center\" style='width: 13%'>Item Name</th>
        <th class=\"text-center\" style='width: 9%'>Item Price</th>
        <th class=\"text-center\" style='width: 9%'>Item Quantity</th>
        <th class=\"text-center\" style='width: 15%'>Order Creation Time</th>
        <th class=\"text-center\" style='width: 20%'>Order Status</th>
        <th class=\"text-center\" style='width: 15%'>Expected Delivery Date</th>
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
    echo " <td align='center' id=''>Total</td>
                            <td align='center' id=''></td>
                           <td align='center' id=''></td>
                            <td align='center' id=''>$total_price</td>
                            <td align='center' id=''>$total_quantity</td>
                            <td align='center' id=''></td>
                            <td align='center' id=''></td>
                                    </tr>";
    echo "</tbody>";
    echo " </table>  <hr class=\"style2\">";
    echo "</div>";
}

?>