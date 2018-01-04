<link rel="stylesheet" href="../css/chatBox.css">
<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 1/3/2018
 * Time: 8:50 PM
 */

$pageTitle = 'Chat With US';

$auth_users = array(1);

include '../_inc/header.php';
include '../_lib/db.conf.php';
include '../_inc/main_user_info.php';
include '../_inc/nav.php';

if(!in_array($curr_client_level, $auth_users)){
    header("Location: ../_inc/login_form.php");
    exit;
}

$chat_id = isset($_GET['chat_id'])?$_GET['chat_id']:null;
$sql = "SELECT client_id FROM client_chats WHERE chat_id = $chat_id LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$client_id = $row['client_id'];

$sql2 = "SELECT clientname FROM clients WHERE cid = $client_id LIMIT 1";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();

echo "<div class=\"wrapper\"> 
        <div class=\"container\">";

echo "<div class=\"row thisClientChatBox\" id='$chat_id'>
        <div class=\"col-md-12\">
            <div class=\"panel panel-primary\">
                <div class=\"panel-heading\">
                    <span class=\"glyphicon glyphicon-comment\"></span> Chat with $row2[clientname]
                    <div class=\"btn-group pull-right\">
                            <a href=\"http://www.jquery2dotnet.com\"><span class=\"glyphicon glyphicon-refresh\">
                            </span>Refresh</a>
                    </div>
                </div>
                <div class=\"panel-body\">
                    <ul class=\"chat chatBody\">
                    
                    </ul>
                </div>
                <div class=\"panel-footer\">
                    <div class=\"input-group\">
                        <input id=\"btn-chat-input\" type=\"text\" class=\"form-control input-sm\" placeholder=\"Type your message here...\" />
                        <span class=\"input-group-btn\">
                            <input type='button' value='Send' class=\"btn btn-warning btn-sm btn-send-chat\" id=\"btn-send-chat\">
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>";


echo "</div></div>";
include '../_inc/footer.php';
mysqli_close($conn);
?>

<script>
    $('#chatPage').addClass("active");
    $chat_id = $('.thisClientChatBox').attr('id');
    $(document).ready(function(){
        $.post("./getCurrentClientChat.php",
            {
                chat_id:$chat_id
            },
            function(data, status){
                $('.chatBody').append(data);
                $ulChatBody = $("ul.chatBody");
                $ulChatBody.scrollTop($ulChatBody[0].scrollHeight);
            });
    });

    $('#btn-send-chat').click(function(){
        $message = $('#btn-chat-input').val();
        $.post("./sendMessage.php",
            {
                message: $message
            },
            function(data, status){
               $ulChatBody = $("ul.chatBody");
                location.reload();
                $ulChatBody.scrollTop($ulChatBody[0].scrollHeight);
            });
    });

</script>
