<link rel="stylesheet" href="../css/chatBox.css">
<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 1/3/2018
 * Time: 8:50 PM
 */

$pageTitle = 'Chat With US';

$auth_users = array(2);

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

echo "<div class=\"row\">
        <div class=\"col-md-12\">
            <div class=\"panel panel-primary\">
                <div class=\"panel-heading\">
                    <span class=\"glyphicon glyphicon-comment\"></span> Chat with the Admin
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
?>

<script>
    $('#chatPage').addClass("active");
    $(document).ready(function(){
        getCurrentClientChat();
    });

    function getCurrentClientChat(){
        $.post("./getCurrentClientChat.php",
            {

            },
            function(data, status){
                $chatBody = $('.chatBody');
                $chatBody.empty();
                $chatBody.append(data);
                $ulChatBody = $("ul.chatBody");
                $ulChatBody.scrollTop($ulChatBody[0].scrollHeight);
            });
    }

    $('#btn-send-chat').click(function(){
        $msgTextarea =  $('#btn-chat-input');
        $message = $msgTextarea.val();
        $.post("./sendMessage.php",
            {
                message: $message
            },
            function(data, status){
                // $('#btn-chat-input').val('');
                $ulChatBody = $("ul.chatBody");
                $msgTextarea.val('');
                getCurrentClientChat();
                $ulChatBody.scrollTop($ulChatBody[0].scrollHeight);
            });
    });

    setInterval(function() {
        getCurrentClientChat();
    },  1000); //  1000 milsec

</script>
