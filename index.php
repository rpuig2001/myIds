<meta charset="UTF-8">
<title>VATSPA IDS</title>
<link rel="icon" href="https://pbs.twimg.com/profile_images/688803104863682561/3w3v-QBc_400x400.png">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

<?php
session_start();
$page = $_SERVER['PHP_SELF'];
?>
<nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo $page?>">VATSPA IDS</a>
</nav>

<style>
    .center {
        margin: auto;
        width: 90%;
        padding: 10px;
    }
    .smallDiv {
        padding: 10px;
        max-height: fit-content;
        width: 90%;
    }
    .bottomDiv {
        margin: auto;
        padding: 10px;
        max-height: fit-content;
        width: 90%;
    }
    .alignleft {
        float: left;
        width:50%;
        text-align: center;
    }
    .aligncenter {
        float: left;
        width:100%;
        text-align:center;
    }
    .alignright {
        float: left;
        width:50%;
        text-align: center;
    }
</style>

<html>
<body style="background-color: #001326; color: white">
<br />
<div class="aligncenter">
    <div class="alignleft">
        <div class="center" style="background-color: #00070d">
            <h1>Online Map</h1>
            <?php
            include("src/map/mapLEXX.php");
            ?>
            <style>
                .button1 {
                    background-color: darkgreen;
                    border: none;
                    color: white;
                    padding: 10px 15px;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 16px;
                    margin: 4px 2px;
                    cursor: pointer;
                    -webkit-transition-duration: 0.4s; /* Safari */
                    transition-duration: 0.4s;
                }
                .button2 {
                    background-color: darkorange;
                    border: none;
                    color: white;
                    padding: 10px 15px;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 16px;
                    margin: 4px 2px;
                    cursor: pointer;
                    -webkit-transition-duration: 0.4s; /* Safari */
                    transition-duration: 0.4s;
                }
            </style>
            <br />
            <form action="src/other/showFlights.php">
                <?php
                    if(isset($_SESSION['showFlights'])) {
                        if ($_SESSION['showFlights']) {
                            $buttonName = "Hide Flights";
                            ?>
                                <input class="button2" type="submit" value="<?php echo $buttonName ?>">
                                <br />
                                <br />
                                <b>IN&OUT</b>: <img src="img/1.png" width="2%"/>  |  <b>ARRIVAL</b>: <img src="img/2.png" width="2%"/>  |  <b>DEPARTURE</b>: <img src="img/3.png" width="2%"/>
                            <?php
                        }else{
                            $buttonName = "Show Flights";
                            ?>
                                <input class="button1" type="submit" value="<?php echo $buttonName ?>">
                            <?php
                        }
                    }else{
                        $buttonName = "Show Flights";
                        ?>
                            <input class="button1" type="submit" value="<?php echo $buttonName ?>">
                        <?php
                    }
                ?>
            </form>
        </div>
        <br />
        <div class="bottomDiv" style="background-color: #00070d">
            <h1>Online ATC</h1>
            <?php
            include("src/onlineList/onlineList.php");
            ?>
        </div>
        <br />
    </div>
    <div class="alignright">
        <div class="smallDiv" style="background-color: #00070d">
            <h1>Weather</h1>
            <div style="margin-left: 35%">
                <?php
                include("src/metar/metar.php");
                ?>
            </div>
            <br />
            <div style="font-size: 16px">
                <?php
                include("src/metar/getMetar.php");
                ?>
            </div>
            <br />
        </div>
        <br />
        <div class="smallDiv" style="background-color: #00070d">
            <h1>Notams</h1>
            <?php
            include("src/notams/notams.php");
            ?>
        </div>
    </div>
</div>
</body>
</html>
