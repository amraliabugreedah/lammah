<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 1/4/2018
 * Time: 12:58 AM
 */

include '../_lib/db.conf.php';
include '../_inc/main_user_info.php';

function dateDiff($date){
    $then = new DateTime($date, new DateTimeZone('Africa/Cairo'));
    $now = new DateTime("now", new DateTimeZone('Africa/Cairo'));
    $sinceThen = $then->diff($now);

    return $sinceThen;

}

$sql2 = "SELECT clientname FROM clients WHERE cid = 2 LIMIT 1";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();

$sql = "SELECT chat_id FROM client_chats WHERE client_id = 2 LIMIT 1";
$result = $conn->query($sql);
if($result->num_rows == 1){
    $row = $result->fetch_assoc();
    $chat_id = $row['chat_id'];
    $sql1 = "SELECT * FROM chat_records WHERE chat_id = $chat_id ORDER BY mid ASC";
    $result1 = $conn->query($sql1);
    while($row1 = $result1->fetch_assoc()){
        $from_client_id = $row1['from_client_id'];
        $message = $row1['message'];
        $creation_time = $row1['creation_time'];
        $sinceThen = dateDiff($creation_time);
        if($from_client_id == 1){  /// right chat
            echo "<li class=\"right clearfix\"><span class=\"chat-img pull-right\">
                            <img src=\"http://placehold.it/50/FA6F57/fff&text=ME\" alt=\"User Avatar\" class=\"img-circle\" />
                        </span>
                            <div class=\"chat-body clearfix\">
                                <div class=\"header\">
                                    <small class=\" text-muted\"><span class=\"glyphicon glyphicon-time\"></span>$sinceThen->d Days and $sinceThen->h:$sinceThen->i ago</small>
                                    <strong class=\"pull-right primary-font\">Admin</strong>
                                </div>
                                <p class='pull-right'>$message</p>
                            </div>
                        </li>";
        }else{ /// left chat
            echo "<li class=\"left clearfix\"><span class=\"chat-img pull-left\">
                            <img src=\"http://placehold.it/50/55C1E7/fff&text=U\" alt=\"User Avatar\" class=\"img-circle\" />
                        </span>
                            <div class=\"chat-body clearfix\">
                                <div class=\"header\">
                                    <strong class=\"primary-font\">".$row2['clientname']."</strong> <small class=\"pull-right text-muted\">
                                        <span class=\"glyphicon glyphicon-time\"></span>$sinceThen->d Days and $sinceThen->h:$sinceThen->i ago</small>
                                </div>
                                <p> $message </p>
                            </div>
                        </li>";
        }
    }
}

mysqli_close($conn);
?>