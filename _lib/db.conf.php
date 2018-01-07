<?php
/**
 * Created by PhpStorm.
 * User: Amr Abu Greedah
 * Date: 12/13/2017
 * Time: 7:07 PM
 */

$dbhost = $_SERVER['RDS_HOSTNAME'];
$dbport = $_SERVER['RDS_PORT'];
$dbname = $_SERVER['RDS_DB_NAME'];
//$charset = 'utf8' ;
$username = $_SERVER['RDS_USERNAME'];
$password = $_SERVER['RDS_PASSWORD'];

//$server_name = 'localhost';
//$username = 'amrabugreedah';
//$password = 'koko1993';
//$db_name = 'lammah_db';

//$conn = mysqli_connect($server_name, $username, $password, $db_name);
$conn = mysqli_connect($dbhost, $username, $password, $dbname, $dbport);
mysqli_set_charset($conn, 'utf8');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
ss