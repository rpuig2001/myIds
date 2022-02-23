<?php

$json = file_get_contents('https://data.vatsim.net/v3/vatsim-data.json');
$obj = json_decode($json);

$total = count($obj->atis);

if(isset($_SESSION['metarAirport'])){
    $metar = file_get_contents('https://metar.vatsim.net/metar.php?id='.$_SESSION['metarAirport']);
    $atisText = "";
    if($metar != ""){
        for ($i = 0; $i<$total; $i++){
            $atcCallsign = $obj->atis[$i]->callsign;
            if($atcCallsign == $_SESSION['metarAirport']."_ATIS"){
                $tempText = $obj->atis[$i]->text_atis;
                foreach($tempText as $text){
                    $atisText .= $text." ";
                }
            }
        }
        $completeMetar = file_get_contents('https://metar.vatsim.net/metar.php?id='.$_SESSION['metarAirport']);
        $metarData = explode(" ", $completeMetar);
        $atisData = explode(" ", $atisText);
        $atisLetter = "";
        for ($i = 0; $i < sizeof($atisData); $i++) {
            if($atisData[$i] == "information" || $atisData[$i] == "INFORMATION"){
                $atisLetter = $atisData[$i+1];
            }
        }
        $wind = $metarData[2];
        foreach ($metarData as $component){
            if(strpos($component, "KT")){
                $wind = $component;
            }
        }
        ?>
            <table style="margin-left: 35%">
                <tr>
                    <td style="padding-right: 15px; font-size: 30px; min-width: 50px"><b><?php echo $_SESSION['metarAirport']?></b></td>
                    <td style="font-size: 50px; min-width: 50px; background-color: grey; margin: auto; padding: 10px"><?php echo substr($atisLetter,0,1) ?></td>
                    <td style="padding-left: 15px;font-size: 30px; min-width: 50px"><?php echo $wind?></td>
                </tr>
            </table>
        <br />
        <?php

        echo $completeMetar;
    }else{
        echo "No airport found";
    }
}else{
    echo "No airport selected";
}
?>