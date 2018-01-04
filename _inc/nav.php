<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 12/13/2017
 * Time: 7:56 PM
 */

echo "<ul>
  <li><a id=\"main\" href=\"../project/main.php\">Main Page</a></li>
  <li><a id=\"newUser\" href=\"../project/new_user.php\">New User</a></li>
  <li><a id=\"users\" href=\"../project/users.php\">Users</a></li>
  <li><a id=\"food\" href=\"../project/products.php\">Products</a></li>
  <li><a id=\"order\" style='display: none' href=\"../project/order.php\">Order</a></li>";
  if($curr_client_level != 1){echo "<li><a id=\"chatPage\" href=\"../project_chat_page/chat_page.php\">Chat With Us</a></li>";}
  else{echo "<li><a id=\"adminChats\" href=\"../project_chat_page_admin/admin_chats.php\">Admin Chats</a></li>";}
  echo"<li class='pull-right'><a id=\"logout\" href=\"../_auth/logout.php\">logout</a></li>
</ul>";


?>
