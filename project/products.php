<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 12/13/2017
 * Time: 8:11 PM
 */
$pageTitle = 'Food';

include '../_inc/header.php';
include '../_inc/nav.php';
include '../_lib/db.conf.php';
include '../_inc/main_user_info.php';


echo "<div class=\"wrapper\"> 
        <div class=\"container\">";

if(isset($_POST['NewOrder'])){
    $user_id = isset($_POST['user_id'])?$_POST['user_id']:null;
    $operation =  'NewOrder';

    $sql = "INSERT INTO orders (client_id, user_id) VALUES ($curr_client_id, $user_id)";
    $conn->query($sql);

    $sql = "SELECT MAX(id) AS id FROM orders";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $order_id = $row['id'];

    $sql1 = "UPDATE users SET last_order_date = NOW() WHERE  id = $user_id";
    $conn->query($sql1);

    $sql = "SELECT mobile FROM users where id = $user_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    $user_mobile = $row['mobile'];




echo "<div class=\"row top-buffer\">";
echo "<div class='row'>";
echo"<div class=\"col-sm-3\">
        <form action='order.php' method='post'>
         <input hidden type='text' id='ExpDeliveryDate' name='ExpDeliveryDate'>
         <input hidden type='text' id='mobile_no' name='mobile_no' value='$user_mobile'>
         <input hidden type='text' id='order_id' name='order_id' value='$order_id'>";
if($curr_client_level == 3) {
    echo "<input type = 'submit' name = 'getUser' style = 'pointer-events: none;' disabled  id = 'backToUserProfile'  value = 'Back To User Profile' class='btn btn-default' >";
    }else{
    echo "<input type = 'submit' name = 'getUser' id = 'backToUserProfile'  value = 'Back To User Profile' class='btn btn-default' >";
}
         echo "</form>
         </div></div>";

if($curr_client_level == 3) {
    echo "<div class='col-sm-3'> <label style='margin-top:8px; '>Enter The Expected Delivery Date:</label></div>";
    echo "<div class='col-sm-6'>
            <div class=\"form-group\">
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' id ='expectedDeliveryDate' class=\"form-control\" />
                    <span class=\"input-group-addon\">
                        <span class=\"glyphicon glyphicon-calendar\"></span>
                    </span>
                </div>
            </div>
        </div>";

    echo "</div>";
}
echo "<div class=\"row table-responsive orderItemsAdded top-buffer ourThemeBF\" style=\"display: none;\" id='orderItemsAdded'>";


echo "<table class=\"table table-hover table-bordered jquery-tablesorter\">";
echo " <thead>
      <tr>
        <th> </th>
        <th> </th>
        <th class=\"text-center\" data-sort=\"num\"  style='width: 25%'>Total Item Price <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
        <th class=\"text-center\" data-sort=\"num\"  style='width: 25%'>Quantity <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
        <th class=\"text-center\" data-sort=\"num\"  style='width: 25%'>Price <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
        <th class=\"text-center\" data-sort=\"text\" style='width: 25%'>Item Name <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
      </tr>
    </thead>";
echo"<tbody>";
   echo "<tr class='totalOfOrder staticRow'><td align='center'>Grand Total</td><td></td><td align='center' class='totalItemPrice'></td><td align='center' class='totalQTY'></td><td></td><td></td></tr>";
echo "</tbody>";
echo " </table>";
echo "</div>";
}
  if (!isset($operation)){
        echo "<div class=\"row button-box\">";
            echo "<div class=\"col-sm-6 \">";
            echo "<form method='post' action='../project_operations/products_settings.php'>
            <input type='submit' name='start_operation' id='start_operation' class=\"btn btn-default\" value='Add New Item'>
            </form>";
            echo "</div>";
            echo "<div class=\"col-sm-6 \">";
            echo "<form method='post' action='../project_operations/products_settings.php'>
                   <input type='submit' name='start_operation' id='start_operation' class=\"btn btn-default\" value='Add New Category'>
                   </form>";
            echo "</div>";
         echo "</div>";
  }

            $sql = "SELECT * FROM food_category WHERE client_id = $curr_client_id";
            $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $sql1 = "SELECT * FROM food_item WHERE category_id = $row[id]";
                    $result1 = $conn->query($sql1);

                    echo "<div class=\"row top-buffer hoverRow bg-1\" id='$row[id]'>";
                    if(!isset($operation)) {
                        echo "<div class=\"col-sm-1\" align='right'>";
                        echo "<form method='post' action='../project_operations/products_settings.php'>
                              <input type='text' name='category_id' id='category_id' hidden value='$row[id]'>
                              <input type='submit' style='margin-top: 25%;' name='start_operation' id='start_operation' class=\"btn btn-default\" value='Edit'>
                              </form>";
                        echo "</div>";
                        echo "<div class=\"col-sm-1\" >";
                        echo "<form method='post' action='../project_operations/products_settings.php'>
                              <input type='text' name='category_id' id='category_id' hidden value='$row[id]'>
                              <input type='submit' style='margin-top: 25%;' name='start_operation' id='start_operation' class=\"btn btn-default\" value='Delete'>
                              </form>";
                        echo "</div>";
                        echo "<div class=\"col-sm-10\" align='right'>";
                        echo "<h1>".$row['category_name']."</h1>";
                        echo "</div>";
                    }else{
                    echo "<div class=\"col-sm-12\" align='right'>";
                    echo "<h1>".$row['category_name']."</h1>";
                    echo "</div>";
                    }
                    echo "</div>";

                    echo "<div class=\"row table-responsive foodMenuItems ourThemeBF top-buffer2\" align=\"right\" style=\"display: none;\" id='$row[id]'>";
                    echo "<table class=\"table table-hover table-bordered jquery-tablesorter\">";
                    echo " <thead>
                               <tr>";
                               if($result1->num_rows == 0){
                                   echo "<th class=\"text-center\" style='width: 25%'> You don't have items in this category, add items or delete the category.</th>";
                               }else{
                    echo " <th class=\"text-center\" style='width: 25%'></th>";
                                                if(isset($operation)){
                                 echo "<th  data-sort=\"num\" class=\"text-center\" style='width: 25%'>Quantity <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>";
                                 }
                                  echo "<th  data-sort=\"num\" class=\"text-center\" style='width: 25%'>Price <i class=\"fa fa-sort\"  aria-hidden=\"true\"></i></th>
                                 <th  data-sort=\"text\" class=\"text-center\" style='width: 25%'>Item Name <i class=\"fa fa-sort\" aria-hidden=\"true\"></i></th>
                               </tr>
                           </thead>";
                               }
                    echo"<tbody>";
                        while($row1 = $result1->fetch_assoc()) {

//                            echo " <div class=\"list-group-item\"> <div class=\"col-sm-4\" >" . $row1['item_name'] . "</div> <div class=\"col-sm-8\" >" . $row1['item_name'] . " </div></div>";

                                   echo"<tr id='$row1[id]'>";
                                   if(!isset($operation)){
                                        echo"<td align=\"center\"> 
                                                <form method='post' action='../project_operations/products_settings.php'>
                                                   <input type='text' name='item_id' id='item_id' hidden value='$row1[id]'>
                                                   <input type='submit' name='start_operation' id='start_operation' class=\"btn btn-default\" value='Edit'>
                                                   <input type='submit' name='start_operation' id='start_operation' class=\"btn btn-default\" value='Delete'>
                                                 </form>
                                                 </td>";
                                   }else{
                                       echo"<td id=$order_id data-value=$user_id align='center'> <a  class=\"btn btn-default add-remove-item-order\" id=$row1[id]>Add</a> </td>";
                                       echo"<td align=\"center\">
                                        <input type=\"number\" min=\"1\" style='width: 40px; ' value='1' id=\"QTY\" name=\"QTY\"> </td>";
                                   }
                                        echo"<td align='center' id='$row1[item_price]'>" . $row1['item_price'] . "</td>
                                        <td align='center' id='$row1[item_name]'>" . $row1['item_name'] . "</td>
                                    </tr>
                                 ";
                        }
                   echo "</tbody>";
                    echo " </table>";
                    echo "</div>";
                }

include '../_inc/footer.php';
echo "</div></div>";
mysqli_close($conn);
?>

<script>
    $permission_to_show_deliver_date = false;
    $permission_to_show_order_item_table = false;
    $('#food').addClass("active");

    $('.hoverRow').click(function () {

        $header = $(this);
        //getting the next element
        $content = $header.next();
        //open up the content needed - toggle the slide- if visible, slide up, if not slidedown.
        $content.slideToggle(500, function () {
            //execute this after slideToggle is done
            //change text of header based on visibility of content div

            if($content.is(":visible")){
                $content.is(":visible", false);
            }else{
                $content.is(":visible", true);
            }

        });

    });
    $total= 0;
    $totalQTY = 0;
    $('.add-remove-item-order').click(function () {
        <?php echo "if($curr_client_level == 2){";?>
        $permission_to_show_deliver_date = true;
        <?php echo"}";?>
        $item_id = $(this).attr('id');
        $user_id = $(this).parent().attr('data-value');
        $order_id = $(this).parent().attr('id');
        $item_price = $(this).parent().next().next().attr('id');
        $item_name = $(this).parent().next().next().next().attr('id');

        if($(this).text() === "Add"){
            $QTY = $(this).parent().next().find('input').val();
            $total = $total + $QTY*$item_price;
            $totalQTY = $totalQTY + parseInt($QTY);
            $orderItemsAddedTable =  $('.orderItemsAdded');
            $orderItemsAddedTable.show();
            $(this).parent().parent().hide();
            $orderItemsAddedTable.is(":visible", true);
            if($permission_to_show_deliver_date === true){
            $backToUserProfile = $('#backToUserProfile');
            $backToUserProfile.attr('disabled', false);
            $backToUserProfile.css('pointer-events', 'auto');
            }
            $permission_to_show_order_item_table = true;
            $('<tr>' +
                '<td></td>' +
                '<td align=\"center\" id=' + $order_id + ' data-value=' + $user_id + '>' +
                ' <a  class=\"btn btn-default add-remove-item-order\" id=' + $item_id + '>Remove</a>' +
                '   </td>' +
                '  <td align=\"center\" >' + $item_price*$QTY + '</td>' +
                '  <td align=\"center\" id=' +$QTY+'>' + $QTY + '</td>' +
                '<td align="center" id=' +$item_price+'>' + $item_price + '</td>' +
                '  <td align=\"center\">' + $item_name + '</td></tr>').insertBefore('tr.totalOfOrder');
            $('td.totalItemPrice').text($total);
            $('td.totalQTY').text($totalQTY);
            $.post("../project_operations/products_settings.php",
                {
                    operation: "AddItemOrder",
                    item_id: $item_id,
                    user_id: $user_id,
                    order_id: $order_id,
                    quantity: $QTY
                },
                function(data, status){});
        }


    });
    $(document).on("click", ".add-remove-item-order" , function() {

        if($(this).text() === "Remove"){
            $(this).parent().parent().remove();
            $item_id = $(this).attr('id');
            $user_id = $(this).parent().attr('data-value');
            $order_id = $(this).parent().attr('id');
            $item_price = $(this).parent().next().next().next().attr('id');
            $QTY = $(this).parent().next().next().attr('id');
            $total = $total - $QTY*$item_price;
            $totalQTY = $totalQTY - parseInt($QTY);
            $('tr[id^='+$item_id+']').show();
            $backToUserProfile = $('#backToUserProfile');
            if( $('.orderItemsAdded tr').length === 2){
                $permission_to_show_order_item_table = false;
                $backToUserProfile.attr('disabled', true);
                $backToUserProfile.css('pointer-events', 'none');
                $('.orderItemsAdded').hide();
            }
            $('td.totalItemPrice').text($total);
            $('td.totalQTY').text($totalQTY);
            $.post("../project_operations/products_settings.php",
                {
                    operation: "RemoveItemOrder",
                    item_id: $item_id,
                    user_id: $user_id,
                    order_id: $order_id
                },
                function(data, status){});
        }

    });
    $today = new Date();
    $(function () {
        $('#datetimepicker1').datetimepicker({
            sideBySide: true,
            stepping: 5,
            minDate:$today,
            format: 'MM/DD/YYYY h:mm'

        });
    });
<?php echo "if($curr_client_level == 3){";?>
    $('#expectedDeliveryDate').on('mouseenter mouseleave click focus blur',function(){
        $ExpDeliveryDate = $('#ExpDeliveryDate');
        $date = $('#datetimepicker1').data("DateTimePicker").date().format("YYYY-MM-DD HH:mm:ss");
        $ExpDeliveryDate.attr('value', $date);
        if($permission_to_show_order_item_table === true){
            $backToUserProfile = $('#backToUserProfile');
            $backToUserProfile.attr('disabled', false);
            $backToUserProfile.css('pointer-events', 'auto');
        }
        $permission_to_show_deliver_date = true;

    });<?php echo "}";?>
</script>

