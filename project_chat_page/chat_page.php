<link rel="stylesheet" href="../css/chatBox.css">
<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 1/3/2018
 * Time: 8:50 PM
 */

$pageTitle = 'Chat With US';

include '../_inc/header.php';
include '../_inc/nav.php';



echo "<div class=\"wrapper\"> 
        <div class=\"container\">";

echo" <div class=\"row responsive\">
        <div class=\"col-md-12\">
            <div class=\"panel panel-primary\">
                <div class=\"panel-heading\">
                    <span class=\"glyphicon glyphicon-comment\"></span> Chat
                    <div class=\"btn-group pull-right\">
                        
                            <a href=\"http://www.jquery2dotnet.com\"><span class=\"glyphicon glyphicon-refresh\">
                            </span>Refresh</a>
                           
                    </div>
                </div>
                <div class=\"panel-body chatBody\" >
                    <ul class=\"chat\">
                        <li class=\"left clearfix\"><span class=\"chat-img pull-left\">
                            <img src=\"http://placehold.it/50/55C1E7/fff&text=U\" alt=\"User Avatar\" class=\"img-circle\" />
                        </span>
                            <div class=\"chat-body clearfix\">
                                <div class=\"header\">
                                    <strong class=\"primary-font\">Jack Sparrow</strong> <small class=\"pull-right text-muted\">
                                        <span class=\"glyphicon glyphicon-time\"></span>12 mins ago</small>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                    dolor, quis ullamcorper ligula sodales.
                                </p>
                            </div>
                        </li>
                        <li class=\"right clearfix\"><span class=\"chat-img pull-right\">
                            <img src=\"http://placehold.it/50/FA6F57/fff&text=ME\" alt=\"User Avatar\" class=\"img-circle\" />
                        </span>
                            <div class=\"chat-body clearfix\">
                                <div class=\"header\">
                                    <small class=\" text-muted\"><span class=\"glyphicon glyphicon-time\"></span>13 mins ago</small>
                                    <strong class=\"pull-right primary-font\">Bhaumik Patel</strong>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                    dolor, quis ullamcorper ligula sodales.
                                </p>
                            </div>
                        </li>
                        <li class=\"left clearfix\"><span class=\"chat-img pull-left\">
                            <img src=\"http://placehold.it/50/55C1E7/fff&text=U\" alt=\"User Avatar\" class=\"img-circle\" />
                        </span>
                            <div class=\"chat-body clearfix\">
                                <div class=\"header\">
                                    <strong class=\"primary-font\">Jack Sparrow</strong> <small class=\"pull-right text-muted\">
                                        <span class=\"glyphicon glyphicon-time\"></span>14 mins ago</small>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                    dolor, quis ullamcorper ligula sodales.
                                </p>
                            </div>
                        </li>
                        <li class=\"right clearfix\"><span class=\"chat-img pull-right\">
                            <img src=\"http://placehold.it/50/FA6F57/fff&text=ME\" alt=\"User Avatar\" class=\"img-circle\" />
                        </span>
                            <div class=\"chat-body clearfix\">
                                <div class=\"header\">
                                    <small class=\" text-muted\"><span class=\"glyphicon glyphicon-time\"></span>15 mins ago</small>
                                    <strong class=\"pull-right primary-font\">Bhaumik Patel</strong>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                    dolor, quis ullamcorper ligula sodales.
                                </p>
                            </div>
                        </li>
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
        $.post("./getCurrentClientChat.php",
            {

            },
            function(data, status){

            });
    });

    $('#btn-send-chat').click(function(){
        $message = $('#btn-chat-input').val();
        $.post("./sendMessage.php",
            {
                message: $message
            },
            function(data, status){
                $('#btn-chat-input').val('');
            });
    });

</script>
