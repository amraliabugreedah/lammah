<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 1/3/2018
 * Time: 5:23 AM
 */
include '../_lib/db.conf.php';
include '../_inc/main_user_info.php';

$sql = "SELECT fi.id, fi.item_name, fc.category_name, SUM(fi.item_price*os.quantity) AS total_paid, SUM(os.quantity) AS total_ordered  FROM orders AS o INNER JOIN order_stuff AS os ON o.id = os.order_id 
        INNER JOIN food_item AS fi ON os.item_id = fi.id INNER JOIN food_category as fc on fi.category_id = fc.id WHERE o.client_id = $curr_client_id AND o.status = 1 GROUP by fi.id ORDER BY total_paid DESC ";
$result = $conn->query($sql);

echo "<div class='col-sm-9 ourThemeBF'>";
echo "<table class=\"table table-hover table-bordered  jquery-tablesorter\" >";
echo " <thead>
      <tr>
        <th class=\"text-center\" style='width:10%' >Item ID </th>
        <th class=\"text-center\" style='width:20%'>Category Name </th>
        <th class=\"text-center\" style='width:20%'>Item Name </th>
        <th class=\"text-center clickableElem\" style='width:30%' data-sort=\"num\" >Total Number of Orders <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
        <th class=\"text-center clickableElem\" style='width:20%' data-sort=\"num\" >Total Paid <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
      </tr>
    </thead>";
echo "<tbody>";
while($row = $result->fetch_assoc()){
    echo"<tr>
          <td align='center'>".$row['id']."</td>
          <td align='center'>".$row['category_name']."</td>
          <td align='center'>".$row['item_name']."</td>
          <td align='center'>".$row['total_ordered']."</td>
          <td align='center'>".$row['total_paid']."</td>
          </tr>";
}
echo "</tbody>";
echo " </table></div>";

mysqli_close($conn);
?>