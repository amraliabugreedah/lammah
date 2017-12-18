<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 12/18/2017
 * Time: 1:59 PM
 */
session_start();

if(session_destroy()) {
    header("Location: ../_inc/login_form.php");
}
?>