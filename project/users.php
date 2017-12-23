<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 12/13/2017
 * Time: 8:11 PM
 */

$pageTitle = 'Users';

include '../_inc/header.php';
include '../_inc/nav.php';
include '../_lib/db.conf.php';
include '../_inc/main_user_info.php';

$sql = "SELECT * FROM users WHERE client_id = $curr_client_id";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

    $sql2 = "SELECT COUNT(DISTINCT o.id) AS total, SUM(fi.item_price) AS total_paid FROM orders AS o INNER JOIN order_stuff AS os 
                    ON o.id = os.order_id INNER JOIN food_item AS fi ON fi.id = os.item_id WHERE os.user_id = $row[id] AND client_id = $curr_client_id";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();

    echo "<div class=\"table-resiponsve col-lg-7\" align=\"center\" style=\"display: block;\" id=''>";
    echo "<table class=\"table table-hover table-bordered table-striped\">";
    echo " <thead>
      <tr>
        <th class=\"text-center\" style='width: 2%'>User ID</th>
        <th class=\"text-center\" style='width: 8%'>First Name</th>
        <th class=\"text-center\" style='width: 13%'>Last Name</th>
        <th class=\"text-center\" style='width: 9%'>Mobile</th>
        <th class=\"text-center\" style='width: 9%'>Address</th>
        <th class=\"text-center\" style='width: 15%'>Status</th>
        <th class=\"text-center\" style='width: 15%'>Total Number Of Orders</th>
        <th class=\"text-center\" style='width: 15%'>Total Paid</th>
        <th class=\"text-center\" style='width: 20%'>Creation Time</th>
        <th class=\"text-center\" style='width: 15%'>Last Order Date</th>
      </tr>
    </thead>";
    echo "<tbody>";
        echo "<tr id=''>";
        echo "              <td align='center' id=''>" . $row['id'] . "</td>
                            <td align='center' id=''>" . $row["first_name"] . "</td>
                            <td align='center' id=''>" . $row["last_name"] . "</td>
                            <td align='center' id=''>" . $row["mobile"] . "</td>
                            <td align='center' id=''>" . $row["address"] . "</td>";
        if ($row["status"] == 1) {
            echo "<td align='center' id=''>><img src='../images/ok.ico' id='$row[id]' alt='Ok' height=\"22\" width=\"22\"></td>";
        } else if ($row["status"] == 0) {
            echo "<td align='center' id=''><img src='../images/alert.ico' id='$row[id]' alt='Alert' height=\"22\" width=\"22\"></td>";
        } else if ($row["status"] == -1) {
            echo "<td align='center' id=''><img src='../images/warning.png' id='$row[id]' alt='Warning' height=\"22\" width=\"22\"></td>";
        }
        echo "<td align='center' id=''>" . $row2["total"] . "</td>";
        echo "<td align='center' id=''>" . $row2["total_paid"] . "</td>";
        echo "<td align='center' id=''>" . $row["creation_time"] . "</td>";
        echo "  <td align='center' id=''>" . $row["last_order_date"] . "</td>";
        echo "</tr>";

    echo "</tbody>";
    echo " </table>  <hr class=\"style2\">";
    echo "</div>";
}



mysqli_close($conn);
include '../_inc/footer.php';
?>

<script>
    $('#users').addClass("active");
</script>

