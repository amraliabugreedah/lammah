<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 12/31/2017
 * Time: 10:39 PM
 */

include '../_lib/db.conf.php';
include '../_inc/main_user_info.php';

$sql = "SELECT u.id AS user_id,  u.first_name, u.last_name, u.mobile, SUM(fi.item_price*os.quantity) AS total_paid FROM users AS u INNER JOIN orders AS o ON u.id = o.user_id INNER JOIN order_stuff AS os ON o.id = os.order_id 
        INNER JOIN food_item AS fi ON os.item_id = fi.id WHERE u.client_id = $curr_client_id AND o.status = 1 GROUP BY u.id ORDER BY total_paid DESC ";
$result = $conn->query($sql);
echo "<div class='col-sm-9 ourThemeBF'>";
echo "<table class=\"table table-hover table-bordered  jquery-tablesorter\" >";
echo " <thead>
      <tr>
        <th class=\"text-center\" style='width:10%'>User ID </th>
        <th class=\"text-center\" style='width:20%'>First Name </th>
        <th class=\"text-center\" style='width:20%'>Last Name </th>
        <th class=\"text-center\" style='width:30%'>Mobile </th>
        <th class=\"text-center clickableElem\" style='width:20%' data-sort=\"num\">Total Paid <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
      </tr>
    </thead>";
echo "<tbody>";
while($row = $result->fetch_assoc()){
    echo"<tr>
          <td align='center'>".$row['user_id']."</td>
          <td align='center'>".$row['first_name']."</td>
          <td align='center'>".$row['last_name']."</td>
          <td align='center'>".$row['mobile']."</td>
          <td align='center'>".$row['total_paid']."</td>
          </tr>";
}
echo "</tbody>";
echo " </table></div>";

mysqli_close($conn);
?>