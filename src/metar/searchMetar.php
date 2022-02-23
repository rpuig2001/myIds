<?php
session_start();

if($_POST['apt'] != ''){
    $_SESSION['metarAirport'] = strtoupper($_POST['apt']);
}else{
    $_SESSION['metarAirport'] = "";
}
header("Location: /ids/index.php");