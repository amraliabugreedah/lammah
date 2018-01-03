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
include '../_lib/db.conf.php';
include '../_inc/main_user_info.php';


echo "<div class=\"wrapper\"> 
        <div class=\"container\">";

echo" <div class=\"row responsive\">
        <div class=\"col-md-12\">
            <div class=\"panel panel-primary\">
                <div class=\"panel-heading\">
                    <span class=\"glyphicon glyphicon-comment\"></span> Chat
                    <div class=\"btn-group pull-right\">
                        <button type=\"button\" class=\"btn btn-default btn-xs dropdown-toggle\" data-toggle=\"dropdown\">
                            <span class=\"glyphicon glyphicon-chevron-down\"></span>
                        </button>
                        <ul class=\"dropdown-menu slidedown\">
                            <li><a href=\"http://www.jquery2dotnet.com\"><span class=\"glyphicon glyphicon-refresh\">
                            </span>Refresh</a></li>
                        </ul>
                    </div>
                </div>
                <div class=\"panel-body\" >
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
                        <input id=\"btn-input\" type=\"text\" class=\"form-control input-sm\" placeholder=\"Type your message here...\" />
                        <span class=\"input-group-btn\">
                            <button class=\"btn btn-warning btn-sm\" id=\"btn-chat\">
                                Send</button>
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

<script> $('#chatPage').addClass("active");</script>
