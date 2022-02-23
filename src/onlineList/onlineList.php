<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<html>
<table class="table">
    <tr>
        <th style="color:white">Callsign</th>
        <th style="color:white">Frequency</th>
        <th style="color:white">Name</th>
        <th style="color:white">Rating</th>
    </tr>
    <?php
    //Data
    $json = file_get_contents('https://data.vatsim.net/v3/vatsim-data.json');
    $obj = json_decode($json);
    $total = count($obj->controllers);
    for ($i = 0; $i<$total; $i++){
        $callsign = $obj->controllers[$i]->callsign;
        if((substr($callsign, 0, 2) == "LE" || substr($callsign, 0, 2) == "GC") && substr($callsign, strlen($callsign)-3) != "OBS"){
            $frequency = $obj->controllers[$i]->frequency;$name = $obj->controllers[$i]->name;$rating = $obj->controllers[$i]->rating;
            ?>
            <tr>
                <td style="color:white"><b><?php echo $callsign;?></td>
                <td style="color:white"><b><?php echo $frequency;?></td>
                <td style="color:white"><b><?php echo $name;?></td>
                <td style="color:white"><b><?php switch ($rating) {
                        case 1:
                            echo "OBS";
                            break;
                        case 2:
                            echo "S1";
                            break;
                        case 3:
                            echo "S2";
                            break;
                        case 4:
                            echo "S3";
                            break;
                        case 5:
                            echo "C1";
                            break;
                        case 7:
                            echo "C3";
                            break;
                        case 8:
                            echo "INS";
                            break;
                        default:
                            echo "N/A";
                    }
                    ?></td>
            </tr>
            <?php
        }
    }
    ?>

</table>
</html>