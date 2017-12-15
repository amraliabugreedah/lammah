<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 12/13/2017
 * Time: 7:07 PM
 */
$server_name = 'localhost';
$username = 'root';
$password = '';
$db_name = 'lammah_db';

$conn = @mysqli_connect($server_name, $username, $password, $db_name);
mysqli_set_charset($conn, 'utf8');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
