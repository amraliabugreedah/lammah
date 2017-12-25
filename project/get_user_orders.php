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
    $sql = "SELECT DISTINCT o.id FROM orders AS o INNER JOIN order_stuff AS os 
                    ON o.id = os.order_id INNER JOIN food_item AS fi ON fi.id = os.item_id WHERE os.user_id = $id AND client_id = $curr_client_id ORDER BY o.expected_delivery_time, o.id ASC";
}else{
    $sql = "SELECT DISTINCT o.id FROM orders AS o INNER JOIN order_stuff AS os 
                    ON o.id = os.order_id INNER JOIN food_item AS fi ON fi.id = os.item_id WHERE os.user_id = $id AND client_id = $curr_client_id ORDER BY  o.expected_delivery_time, o.id ASC LIMIT $startRow, 4";
}

$result = $conn->query($sql);
while($row = $result->fetch_assoc()){

        $sql2 = "SELECT o.id, o.creation_time, o.expected_delivery_time, o.status, os.quantity, fi.item_name, fi.item_price FROM orders AS o INNER JOIN order_stuff AS os 
                    ON o.id = os.order_id INNER JOIN food_item AS fi ON fi.id = os.item_id WHERE o.id = $row[id] AND os.user_id = $id AND client_id = $curr_client_id ORDER BY o.expected_delivery_time, o.id, fi.item_name ASC";

    $result2 = $conn->query($sql2);

    echo "<div class=\"row table-responsive\" align=\"center\" style=\"display: block;\" id=''>";
    echo "<table class=\"table table-hover table-bordered table-striped jquery-tablesorter\">";
    echo " <thead>
      <tr>
        <th class=\"text-center\" style='width: 2%'></th>
        <th class=\"text-center\" style='width: 8%'>Order ID</th>
        <th class=\"text-center\" data-sort=\"text\" style='width: 13%'>Item Name <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
        <th class=\"text-center\" data-sort=\"num\" style='width: 9%'>Item Price <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
        <th class=\"text-center\" data-sort=\"num\" style='width: 11%'>Item Quantity <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
        <th class=\"text-center\" style='width: 20%'>Order Status</th>
        <th class=\"text-center\" style='width: 15%'>Order Creation Time</th>
        <th class=\"text-center\" style='width: 15%'>Expected Delivery Date</th>
      </tr>
    </thead>";
    echo "<tbody>";
    $total_price = 0;
    $total_quantity = 0;
    while($row2 = $result2->fetch_assoc()) {
        $total_price = $total_price + $row2["item_price"];
        $total_quantity = $total_quantity + $row2["quantity"];
        echo "<tr id=''>";
        echo "  <td align='center' id=''></td>
                            <td align='center' id=''>" . $row2['id'] . "</td>
                            <td align='center' id=''>" . $row2["item_name"] . "</td>
                            <td align='center' id=''>" . $row2["item_price"] . "</td>
                            <td align='center' id=''>" . $row2["quantity"] . "</td>";
        if ($row2["status"] == 1) {
            echo "<td align='center' id=''>Delivered</td>";
        } else if ($row2["status"] == 0) {
            echo "<td align='center' id=''>Order Not Delivered Yet</td>";
        } else if ($row2["status"] == -1) {
            echo "<td align='center' id=''>Cancelled</td>";
        }
        echo "   <td align='center' id=''>" . $row2["creation_time"] . "</td>
        
        <td align='center' id=''>" . $row2["expected_delivery_time"] . "</td>";
        echo "</tr>";
    }
    echo "<tr class='staticRow'>";
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