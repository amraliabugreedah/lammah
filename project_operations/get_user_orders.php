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

if($orders_num < 5){ //////// order by o.expected_delivery_time if it's needed  in both conditions
    $sql = "SELECT DISTINCT o.id FROM orders AS o INNER JOIN order_stuff AS os 
                    ON o.id = os.order_id INNER JOIN food_item AS fi ON fi.id = os.item_id WHERE os.user_id = $id AND client_id = $curr_client_id";
    if($curr_client_level == 2){
        $sql .= " ORDER BY o.id DESC";
    }else if($curr_client_level == 3){
        $sql .= " ORDER BY o.expected_delivery_time, o.id ASC";
    }else if($curr_client_level == 1){
        $sql .= " ORDER BY o.id DESC";
    }
}else{
    $sql = "SELECT DISTINCT o.id FROM orders AS o INNER JOIN order_stuff AS os 
                    ON o.id = os.order_id INNER JOIN food_item AS fi ON fi.id = os.item_id WHERE os.user_id = $id AND client_id = $curr_client_id";
    if($curr_client_level == 2){
        $sql .= " ORDER BY o.id DESC";
    }else if($curr_client_level == 3){
        $sql .= " ORDER BY o.expected_delivery_time, o.id ASC";
    }else if($curr_client_level == 1){
        $sql .= " ORDER BY o.id DESC";
    }
    $sql .= " LIMIT $startRow, 4";
}
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){

        $sql2 = "SELECT o.id, o.creation_time, o.expected_delivery_time, o.status, os.quantity, fi.item_name, fi.item_price FROM orders AS o INNER JOIN order_stuff AS os 
                    ON o.id = os.order_id INNER JOIN food_item AS fi ON fi.id = os.item_id WHERE o.id = $row[id] AND os.user_id = $id AND client_id = $curr_client_id ORDER BY  fi.item_name ASC";

    $result2 = $conn->query($sql2);

    echo "<div class=\"row table-responsive \" align=\"center\" style=\"display: block; padding-bottom: 70px\" id=''>";
    echo "<div class='col-sm-6'>";
    echo "<table class=\"table table-hover table-bordered jquery-tablesorter ourThemeBF\">";
    echo " <thead>
      <tr>
        <th class=\"text-center\" style='width: 2%'></th>
        <th class=\"text-center clickableElem\" data-sort=\"text\" style='width: 13%'>Item Name <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
        <th class=\"text-center clickableElem\" data-sort=\"num\" style='width: 9%'>Item Price <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
        <th class=\"text-center clickableElem\" data-sort=\"num\" style='width: 11%'>Item Quantity <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
      </tr>
    </thead>";
    echo "<tbody>";
    $total_price = 0;
    $total_quantity = 0;
    while($row2 = $result2->fetch_assoc()) {
        $total_price = $total_price + $row2["item_price"]* $row2["quantity"];
        $total_quantity = $total_quantity + $row2["quantity"];
        echo "<tr id=''>";
        echo "  <td align='center' id=''></td>
                            <td align='center' id=''>" . $row2["item_name"] . "</td>
                            <td align='center' id=''>" . $row2["item_price"] . "</td>
                            <td align='center' id=''>" . $row2["quantity"] . "</td>";
        echo "</tr>";
    $order_id = $row2['id'];
    $order_status = $row2["status"];
    $order_creation_time = $row2["creation_time"];
    if($curr_client_level == 3){
        $order_expected_time = $row2["expected_delivery_time"];
    }
    }
    echo "<tr class='staticRow'>";
    echo " <td align='center' id=''>Total</td>
                            <td align='center' id=''></td>
                            <td align='center' id=''>$total_price</td>
                            <td align='center' id=''>$total_quantity</td>
                                    </tr>";
    echo "</tbody>";
    echo " </table></div>";
    echo "<div class='col-sm-6'>";
    echo "<table class=\"table table-hover table-bordered jquery-tablesorter ourThemeBF\">";
    echo " <thead>
      <tr>
        <th class=\"text-center\" >Title</th>
        <th class=\"text-center\" >Information </th>
      </tr>
    </thead>";
    echo "<tbody>";
    echo "<tr id=''>";
    echo "     <td align='center' id=''>Order ID</td>  <td align='center' id=''>" . $order_id. "</td></tr>";
    echo "<tr id=''>";

    echo "     <td align='center' id=''>Order Status</td>";

    echo "<td align='center'> <div class=\"dropdown\">";
    if ($order_status == 1) {
        echo "<a class='orderStatus clickableElem' id='$order_id' >Done</a>";
    } else if ($order_status == 0) {
        echo "<a class='orderStatus clickableElem' id='$order_id' >In Process</a>";
    } else if ($order_status == -1) {
        echo "<a class='orderStatus clickableElem' id='$order_id'>Cancelled</a>";
    }
   echo "<div class=\"dropdown-content\" id='$order_id' style='margin-top: -1px;'>
                                <a class='status_order' id='In Process'>In Process</a>
                                <a class='status_order' id='Done'>Done</a>
                                <a class='status_order' id='Cancelled'>Cancelled</a>
                              </div>
                            </div>";
echo "</td>";
    echo"</tr>";

    echo "<tr id=''>";
    echo "     <td align='center' id=''>Order Creation Time</td> <td align='center' id=''>" .$order_creation_time . "</td></tr>";
    if($curr_client_level == 3){
    echo "<tr id=''>";
    echo "     <td align='center' id=''>Expected Delivery Date</td> <td align='center' id=''>" .$order_expected_time . "</td></tr>";
    }
    echo "</tbody>";
    echo " </table> </div> ";
    echo "</div>  ";


    echo "<hr class=\"style2\">";
                             
}

?>