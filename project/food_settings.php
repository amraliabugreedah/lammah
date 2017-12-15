<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 12/14/2017
 * Time: 7:07 PM
 */
$pageTitle = 'Food Settings';

include '../_inc/header.php';
include '../_inc/nav.php';
include '../_lib/db.conf.php';

$food_setting = isset($_GET['operation'])?$_GET['operation']:null;
$operation =  isset($_POST['operation'])?$_POST['operation']:null;
$item_id = isset($_POST['item_id'])?$_POST['item_id']:null;
$user_id = isset($_POST['user_id'])?$_POST['user_id']:null;
$order_id = isset($_POST['order_id'])?$_POST['order_id']:null;

if($operation == "AddItemOrder"){
    $sql1 = "INSERT INTO order_stuff (order_id, user_id, item_id) VALUES ($order_id, $user_id, $item_id)";
    $conn->query($sql1);

}else if($operation == "RemoveItemOrder"){
    $sql1 = "DELETE FROM order_stuff WHERE item_id = $item_id AND order_id = $order_id AND user_id = $user_id";
    $conn->query($sql1);
}

if(isset($_POST['ANI'])){
    $food_category_id = $_POST['sel1'];
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];
    $sql1 = "INSERT INTO food_item (category_id, item_name, item_price) VALUES ($food_category_id, '$item_name', $item_price)";
    $conn->query($sql1);
}else if(isset($_POST['ANG'])){
    $food_category_name = $_POST['category_name'];
    $sql1 = "INSERT INTO food_category (category_name) VALUES ('$food_category_name')";
    $conn->query($sql1);
}else if(isset($_POST['Edit'])){
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];

    $sql1 = "UPDATE food_item SET item_name = '$item_name', item_price = $item_price WHERE  id = $item_id";
    echo "\n$sql1\n";
    $conn->query($sql1);
}

echo "<div class=\"container\" align='right'>";


if($food_setting == 'ANI'){
    $sql = "SELECT * FROM food_category";
    $result = $conn->query($sql);

    echo " <form method=\"POST\" action=\"$_SERVER[PHP_SELF]\">";
    echo "<div class=\"form-group\">
        <label for=\"sel1\">Select list:</label>
        <select class=\"form-control\" id=\"sel1\" name=\"sel1\">";
    while($row = $result->fetch_assoc()) {
        echo "<option id = $row[id] value='$row[id]'> $row[category_name]</option>";
    }
    echo " </select>
   </div>";
    echo "<div class=\"form-group\">
   <label for=\"item_name\">Item Name </label> 
   <input type=\"text\" required class=\"form-control\" id=\"item_name\" placeholder=\"Enter Item Name\" name=\"item_name\">
   </div>";
    echo "<div class=\"form-group\">
   <label for=\"item_price\">Item Price </label> 
   <input type=\"text\" required class=\"form-control\" id=\"item_price\" placeholder=\"Enter Item Price\" name=\"item_price\">
   </div>";
    echo " <input type=\"submit\"  class=\"btn btn-default\" name=\"ANI\" id=\"ANI\" value=\"Submit\">
</form> ";
}else if($food_setting == 'ANG'){
    echo " <form method=\"POST\" action=\"$_SERVER[PHP_SELF]\">";
    echo "<div class=\"form-group\">
   <label for=\"category_name\">Category Name </label> 
   <input type=\"text\" required class=\"form-control\" id=\"category_name\" placeholder=\"Enter Category Name\" name=\"category_name\">
   </div>";
    echo " <input type=\"submit\"  class=\"btn btn-default\" name=\"ANG\" id=\"ANG\" value=\"Submit\">
 
    </form>";
}else if($food_setting == 'Edit'){
    $item_id = $_GET['id'];
    $sql = "SELECT * FROM food_item WHERE id =  $item_id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    echo " <form method=\"POST\" action=\"$_SERVER[PHP_SELF]\">";
    echo "<input type=\"number\" required class=\"form-control\"  style=\"display:none;\" id=\"item_id\" name=\"item_id\" value='$item_id'>";
    echo "<div class=\"form-group\">
   <label for=\"item_name\">Item Name </label> 
   <input type=\"text\" required class=\"form-control\"  style=\"text-align:right;\" id=\"item_name\" name=\"item_name\" value='$row[item_name]'>
   </div>";
    echo "<div class=\"form-group\">
   <label for=\"item_price\">Item Price </label> 
   <input type=\"number\" required class=\"form-control\"  style=\"text-align:right;\" id=\"item_price\" name=\"item_price\" value='$row[item_price]'>
   </div>";
    echo " <input type=\"submit\"  class=\"btn btn-default\" name=\"Edit\" id=\"Edit\" value=\"Submit\">
 
    </form>";
}


echo "</div>";

mysqli_close($conn);
include '../_inc/footer.php';
?>