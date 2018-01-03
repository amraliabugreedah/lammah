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

echo "<div class=\"wrapper\">
		<div class=\"container\" style='width: 80%'>";

    echo "<div class=\"table-responsive row ourThemeBF\"  id=''>";
    echo "<div class=\"form-group pull-right\">
    <input type=\"text\" class=\"search form-control\" placeholder=\"What you looking for?\">
    </div>
    <span class=\"counter pull-right\"></span>";
    echo "<table class=\"table table-hover table-bordered jquery-tablesorter results\">";
    echo " <thead>
      <tr>
        <th class=\"text-center clickableElem\" data-sort=\"num\" >User ID  <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
        <th class=\"text-center clickableElem\" data-sort=\"text\" >First Name  <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
        <th class=\"text-center clickableElem\" data-sort=\"text\" >Last Name  <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
        <th class=\"text-center\" >Mobile</th>
        <th class=\"text-center\" >Address</th>
        <th class=\"text-center\" >Status</th>
        <th class=\"text-center clickableElem\" data-sort=\"num\" >Total Number Of Orders <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
        <th class=\"text-center clickableElem\" data-sort=\"num\" >Total Paid  <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
        <th class=\"text-center clickableElem\" data-sort=\"date\">Creation Time  <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
        <th class=\"text-center clickableElem\" data-sort=\"date\" >Last Order Date  <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
      </tr>
    </thead>";
    echo "<tbody>";
$sql = "SELECT * FROM users WHERE client_id = $curr_client_id";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){

    $sql2 = "SELECT COUNT(DISTINCT o.id) AS total, SUM(fi.item_price) AS total_paid FROM orders AS o INNER JOIN order_stuff AS os 
                    ON o.id = os.order_id INNER JOIN food_item AS fi ON fi.id = os.item_id WHERE o.status = 1 AND os.user_id = $row[id] AND client_id = $curr_client_id";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
        echo "<tr id=''>";
        echo "              <td align='center' id=''><a href='order.php?mobile_no=$row[mobile]'>$row[id]</a></td>
                            <td align='center' id=''>" . $row["first_name"] . "</td>
                            <td align='center' id=''>" . $row["last_name"] . "</td>
                            <td align='center' id=''>" . $row["mobile"] . "</td>
                            <td align='center' id=''>" . $row["address"] . "</td>";
        if ($row["status"] == 1) {
            echo "<td align='center' id=''><img src='../images/ok.ico' id='$row[id]' alt='Ok' height=\"22\" width=\"22\"></td>";
        } else if ($row["status"] == 0) {
            echo "<td align='center' id=''><img src='../images/alert.ico' id='$row[id]' alt='Alert' height=\"22\" width=\"22\"></td>";
        } else if ($row["status"] == -1) {
            echo "<td align='center' id=''><img src='../images/warning.png' id='$row[id]' alt='Warning' height=\"22\" width=\"22\"></td>";
        }
        echo "<td align='center' id=''>" . $row2["total"] . "</td>";
        if( $row2["total_paid"] == 0){
            echo "<td align='center' id=''>0</td>";
        }else{
        echo "<td align='center' id=''>" . $row2["total_paid"] . "</td>";
        }
        echo "<td align='center' id=''>" . $row["creation_time"] . "</td>";
        echo "  <td align='center' id=''>" . $row["last_order_date"] . "</td>";
        echo "</tr>";
}
    echo"<tr class=\"danger no-result\" style='color: black'>
          <td colspan=\"10\" align='center'><i class=\"fa fa-warning\"></i> No result</td>
          </tr>";
    echo "</tbody>";
    echo " </table>";
    echo "</div>";





include '../_inc/footer.php';
echo "</div></div>";
mysqli_close($conn);
?>

<script>
    $('#users').addClass("active");

    $(document).ready(function() {
        $(".search").keyup(function () {
            var searchTerm = $(".search").val();
            var searchSplit = searchTerm.replace(/ /g, "'):contains('");

            $.extend($.expr[':'], {'contains': function(elem, i, match, array){
                    return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
                }
            });

            $(".results tbody tr").not(":contains('" + searchSplit + "')").each(function(e){
                $(this).attr('visible','false');
            });

            $(".results tbody tr:contains('" + searchSplit + "')").each(function(e){
                $(this).attr('visible','true');
            });

            var jobCount = $('.results tbody tr[visible="true"]+:not(\"no-result\")').length;
            $('.counter').text(jobCount + ' item');

            if(jobCount == '0') {$('.no-result').show();}
            else {$('.no-result').hide();}
        });
    });
</script>

