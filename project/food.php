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

if(isset($_GET['operation']) == "NewOrder"){
    $user_id = isset($_GET['id'])?$_GET['id']:null;
    $operation =  'NewOrder';

    $sql = "INSERT INTO orders (user_id) VALUES ($user_id)";
    $conn->query($sql);
    $sql = "SELECT MAX(id) AS id FROM orders";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $order_id = $row['id'];

}

echo "<div class=\"container\" align='right'>";
echo "<div class=\"row table-responsive orderItemsAdded\" align=\"right\" style=\"display: none;\" id='orderItemsAdded'>";
echo "<table class=\"table table-hover table-bordered table-striped\">";
echo " <thead>
      <tr>
        <th> </th>
         <th class=\"text-center\">Total</th>
        <th class=\"text-center\">Quantity</th>
        <th class=\"text-center\">Price</th>
        <th class=\"text-center\">Item Name</th>
      </tr>
    </thead>";
echo"<tbody>";
   echo "<tr class='totalOfOrder'><td></td><td align='center' class='totalCol'>ss</td><td></td><td></td><td></td></tr>";
echo "</tbody>";
echo " </table>";
echo "</div>";

  if (!isset($operation)){
        echo "<div class=\"row button-box\">";
            echo "<div class=\"col-sm-6 \">";
            echo "<a  class=\"btn btn-default\" href=\"./food_settings.php?operation=ANI\">Add New Item</a>";
            echo "</div>";
            echo "<div class=\"col-sm-6 \">";
            echo "<a  class=\"btn btn-default\" href=\"./food_settings.php?operation=ANG\">Add New Category</a>";
            echo "</div>";
         echo "</div>";
  }

            $sql = "SELECT * FROM food_category";
            $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    $sql1 = "SELECT * FROM food_item WHERE category_id = $row[id]";
                    $result1 = $conn->query($sql1);

                    echo "<div class=\"row top-buffer hoverRow\" align=\"right\" id='$row[id]'>";
                    echo "<div class=\"col-sm-12 bg-1\" align='right'>";
                    echo "<h1>".$row['category_name']."</h1>";
                    echo "</div>";
                    echo "</div>";
                    echo "<div class=\"row table-responsive foodMenuItems\" align=\"right\" style=\"display: none;\" id='$row[id]'>";
                    echo "<table class=\"table table-hover table-bordered table-striped\">";
                    echo"<tbody>";
                        while($row1 = $result1->fetch_assoc()) {

//                            echo " <div class=\"list-group-item\"> <div class=\"col-sm-4\" >" . $row1['item_name'] . "</div> <div class=\"col-sm-8\" >" . $row1['item_name'] . " </div></div>";

                                   echo"<tr id='$row1[id]'>";
                                   if(!isset($operation)){
                                        echo"<td align=\"center\"> <a  class=\"btn btn-default\" href=\"./food_settings.php?operation=Edit&id=$row1[id]\">Edit</a> </td>";
                                   }else{
                                       echo"<td id=$order_id data-value=$user_id align='center'> <a  class=\"btn btn-default add-remove-item-order\" id=$row1[id]>Add</a> </td>";
                                       echo"<td align=\"center\">Quantity
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
echo "</div>";
mysqli_close($conn);
include '../_inc/footer.php';
?>

<script>
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
    $('.add-remove-item-order').click(function () {
        $item_id = $(this).attr('id');
        $user_id = $(this).parent().attr('data-value');
        $order_id = $(this).parent().attr('id');
        $item_price = $(this).parent().next().next().attr('id');
        $item_name = $(this).parent().next().next().next().attr('id');

        if($(this).text() == "Add"){
            $QTY = $(this).parent().next().find('input').val();
            $total = $total + $QTY*$item_price;
            $('.orderItemsAdded').show();
            $(this).parent().parent().hide();
            $orderItemsAddedTable =  $('.orderItemsAdded');
            $orderItemsAddedTable.is(":visible", true);
            $('<tr>' +
                '<td align=\"center\" id=' + $order_id + ' data-value=' + $user_id + '>' +
                ' <a  class=\"btn btn-default add-remove-item-order\" id=' + $item_id + '>Remove</a>' +
                '   </td>' +
                '  <td align=\"center\" >' + $item_price*$QTY + '</td>' +
                '  <td align=\"center\" id=' +$QTY+'>' + $QTY + '</td>' +
                '<td align="center" id=' +$item_price+'>' + $item_price + '</td>' +
                '  <td align=\"center\">' + $item_name + '</td></tr>').insertBefore('tr.totalOfOrder');
            $('td.totalCol').text($total);
            $.post("./food_settings.php",
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

        if($(this).text() == "Remove"){
            $(this).parent().parent().remove();
            $item_id = $(this).attr('id');
            $user_id = $(this).parent().attr('data-value');
            $order_id = $(this).parent().attr('id');
            $item_price = $(this).parent().next().next().next().attr('id');
            $QTY = $(this).parent().next().next().attr('id');
            $total = $total - $QTY*$item_price;
            $('tr[id^='+$item_id+']').show();

            if( $('.orderItemsAdded tr').length == 2){
                $('.orderItemsAdded').hide();
            }
            $('td.totalCol').text($total);
            $.post("./food_settings.php",
                {
                    operation: "RemoveItemOrder",
                    item_id: $item_id,
                    user_id: $user_id,
                    order_id: $order_id
                },
                function(data, status){});
        }

    });
</script>

