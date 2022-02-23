<?php
session_start();

if(isset($_SESSION['showFlights'])){
    if($_SESSION['showFlights']){
        $_SESSION['showFlights'] = false;
    }else{
        $_SESSION['showFlights'] = true;
    }
}else{
    $_SESSION['showFlights'] = true;
}
header("Location: /ids/index.php");