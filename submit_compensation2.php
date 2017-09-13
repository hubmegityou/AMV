<?php

session_start();

$val = $_POST['val'];
$account = $_POST['account'];
$select = $_POST['select'];

require_once "database/dbinfo.php";
require_once "database/connect.php";
$connection = db_connection();

$sql = "UPDATE  $db_compensation_tab SET $db_compensation_account = '$account', $db_compensation_currency = '$select', $db_compensation_payment = '$val' WHERE  $db_compensation_id=".$_SESSION['compensation'];
$connection->query($sql);