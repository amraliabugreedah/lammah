<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 1/4/2018
 * Time: 9:48 PM
 */
$pageTitle = 'Clients Full Info';

$auth_users = array(1);

include '../_inc/header.php';
include '../_lib/db.conf.php';
include '../_inc/main_user_info.php';
include '../_inc/nav.php';

if(!in_array($curr_client_level, $auth_users)){
    header("Location: ../_inc/login_form.php");
    exit;
}


echo "<div class=\"wrapper\"> 
        <div class=\"container\">";
echo "<div class='col-sm-9 ourThemeBF'>";
echo "<table class=\"table table-hover table-bordered  jquery-tablesorter\" >";
echo " <thead>
      <tr>
        <th class=\"text-center\" style='width:10%' >Client ID </th>
        <th class=\"text-center\" style='width:20%'>Client Name </th>
        <th class=\"text-center\" style='width:20%'>Client Level </th>
        <th class=\"text-center clickableElem\" style='width:20%' data-sort=\"date\">Client Creation Time </th>
        <th class=\"text-center\" style='width:10%' >Chat ID </th>
        <th class=\"text-center\" style='width:20%'>Chat Creation Time </th>
      </tr>
    </thead>";
echo "<tbody>";
$sql = "SELECT * FROM client_chats";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
    $sql1 = "SELECT cid, clientname, client_level, active, creation_time FROM clients WHERE cid = $row[client_id] LIMIT 1";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_assoc();
    echo"<tr>
          <td align='center'>".$row1['cid']."</td>
          <td align='center'>".$row1['clientname']."</td>
          <td align='center'>".$row1['client_level']."</td>
          <td align='center'>".$row1['creation_time']."</td>
          <td align='center'><a href='./chat_page.php?chat_id=$row[chat_id]'>$row[chat_id]</a></td>
          <td align='center'>".$row['creation_time']."</td>
          </tr>";
}
echo "</tbody>";
echo " </table></div>";

echo "</div></div>";
include '../_inc/footer.php';
mysqli_close($conn);
?>

<script>
    $('#adminChats').addClass("active");</script>
