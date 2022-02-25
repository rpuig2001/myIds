<?php
$page = $_SERVER['PHP_SELF'];
$sec = "60";
?>

<!DOCTYPE html>
<html>
<meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<body>

</body>
</html>

<?php
$json = file_get_contents('https://data.vatsim.net/v3/vatsim-data.json');
$obj = json_decode($json);

$total = count($obj->pilots);

?>

<div id="mapid" style="width: 100%; height: 600px;" ></div>
<script>

    var mymap = L.map('mapid').setView([40, -5], 5);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
        maxZoom: 18,
        id: 'mapbox/dark-v10',
        tileSize: 512,
        zoomOffset: -1
    }).addTo(mymap);


    <?php
    //Show Pilots
    if(isset($_SESSION['showFlights'])){
        if($_SESSION['showFlights']){
    for ($i = 0; $i<$total; $i++){
    if (isset($obj->pilots[$i]->flight_plan->route)){
    $aircraftShort = $obj->pilots[$i]->flight_plan->aircraft_short;
    $alt = $obj->pilots[$i]->altitude;
    $depApt = $obj->pilots[$i]->flight_plan->departure;
    $arrApt = $obj->pilots[$i]->flight_plan->arrival;
    $callsign = $obj->pilots[$i]->callsign;
    $heading = $obj->pilots[$i]->heading;
    $latitude = $obj->pilots[$i]->latitude;
    $longitude = $obj->pilots[$i]->longitude;
    if($alt > 5000){
    if ((substr($arrApt,0, 2) == "LE" || substr($arrApt, 0,2) == "GC") && (substr($depApt,0, 2) == "LE" || substr($depApt, 0,2) == "GC")){
    ?>
    var planeIcon = L.icon({
        iconUrl: 'img/inair/' + <?php echo $heading ?> + '.png',
        iconSize: [20, 20],
        shadowUrl: 'img/1.png',
        shadowSize: [20, 20]
    });
    L.marker([<?php echo $latitude ?>, <?php echo $longitude ?>], {icon: planeIcon}).addTo(mymap).bindPopup("<b><?php echo $callsign ?></b> <?php echo " - ", $aircraftShort ?> <br> <?php echo $depApt, " - ", $arrApt ?> <br> <?php if(isset($adsb)){ echo $adsb; } ?>");
    <?php
    }else if(substr($arrApt,0, 2) == "LE" || substr($arrApt, 0,2) == "GC"){
    ?>
    var planeIcon = L.icon({
        iconUrl: 'img/inair/' + <?php echo $heading ?> + '.png',
        iconSize: [20, 20],
        shadowUrl: 'img/2.png',
        shadowSize: [20, 20]
    });
    L.marker([<?php echo $latitude ?>, <?php echo $longitude ?>], {icon: planeIcon}).addTo(mymap).bindPopup("<b><?php echo $callsign ?></b> <?php echo " - ", $aircraftShort ?> <br> <?php echo $depApt, " - ", $arrApt ?> <br> <?php if(isset($adsb)){ echo $adsb; } ?>");
    <?php
    }else if(substr($depApt,0, 2) == "LE" || substr($depApt, 0,2) == "GC"){
    ?>
    var planeIcon = L.icon({
        iconUrl: 'img/inair/' + <?php echo $heading ?> + '.png',
        iconSize: [20, 20],
        shadowUrl: 'img/3.png',
        shadowSize: [20, 20]
    });
    L.marker([<?php echo $latitude ?>, <?php echo $longitude ?>], {icon: planeIcon}).addTo(mymap).bindPopup("<b><?php echo $callsign ?></b> <?php echo " - ", $aircraftShort ?> <br> <?php echo $depApt, " - ", $arrApt ?> <br> <?php if(isset($adsb)){ echo $adsb; } ?>");
    <?php
    }
    }
    }
    }
    }
    }
    ?>
</script>

<?php


$total = count($obj->controllers);
$csFound = false;


$APTdata = [["LEBL",41.29849566021584, 2.0823312745475477], ["LEPA",39.55159728353086, 2.7357665968300964],
    ["LEIB",38.87281863487574, 1.3726221932860507], ["LEMH",39.86201314542871, 4.220840782777475],
    ["LEVC",39.48888155085828, -0.4784904826895333], ["LEAL",38.285619284879445, -0.5600421420040986],
    ["LEMI",37.80304782932502, -1.1296206330061471], ["LEZG",41.663116495467364, -1.0535474046214148],
    ["LEBB",43.30215409511018, -2.911195633477415], ["LEMD",40.49334937917182, -3.5691221402735853],
    ["LEAS",43.56040894474824, -6.032427825147485], ["LECO",43.30204376806028, -8.380789847148463],
    ["LEST",42.89750570977731, -8.418151195299636], ["LEVX",42.22493903594128, -8.631610113617091],
    ["LEMG",36.67728726066239, -4.492349668239185], ["LEZL",37.42106807858187, -5.897411355982313],
    ["LEGR",37.18667269837861, -3.7778297763717963], ["LEAM",36.845984297202065, -2.3717708217152675],
    ["LEJR",37.18655321924685, -3.777069075709329], ["GCRR",28.95087402180236, -13.606788465321847],
    ["GCFV",28.45349245100724, -13.867399410541664], ["GCCA",28.774760069428613, -13.679091545500007],
    ["GCLP",27.932098285017297, -15.389490697683046], ["GCXO",28.486405410179337, -16.345628000082723],
    ["GCTS",28.046699192818465, -16.57649382427182], ["GCLA",28.62239463461159, -17.75383451266668]];
$airportsToAdd = [];
for ($i = 0; $i < sizeof($APTdata); $i++) {
    $positionsToAdd = [];
    for ($j = 0; $j < $total; $j++) {
            if (substr($obj->controllers[$j]->callsign, 0, 4) == $APTdata[$i][0]) {
                $callsign = $obj->controllers[$j]->callsign;
                $frequecia = $obj->controllers[$j]->frequency;
                array_push($positionsToAdd,[$callsign, $frequecia]);
            }
    }
    array_push($airportsToAdd,$positionsToAdd);
}

for ($i = 0; $i < sizeof($APTdata); $i++) {
if(sizeof($airportsToAdd[$i]) > 0){
    ?>
    <script>
        var planeIcon = L.icon({
            iconUrl: 'img/atc.png',
            iconSize: [25, 25]
        });
        L.marker([<?php echo $APTdata[$i][1] ?>, <?php echo $APTdata[$i][2] ?>], {icon: planeIcon}).addTo(mymap).bindPopup("<?php
            if(sizeof($airportsToAdd[$i]) > 0){
                for ($a = 0; $a < sizeof($airportsToAdd[$i]); $a++) {
                    if(strlen($airportsToAdd[$i][$a][0]) >= 3){
                        $lastLetters = substr($airportsToAdd[$i][$a][0],strlen($airportsToAdd[$i][$a][0])-3);
                        if($lastLetters == "DEL" || $lastLetters == "GND" || $lastLetters == "TWR" || $lastLetters == "APP"){
                            ?> <b> <?php echo $airportsToAdd[$i][$a][0] ?></b> <?php echo " - ", $airportsToAdd[$i][$a][1];?><br /><?php
                        }
                    }
                }
            }
            ?>");
    </script>
    <?php
}
}

//Sectors
//LECB
/*
 * 0:PPI|1:CCC|2:VNI|3:MVS|4:LLI|5:LECP|6:LECL|7:SAI|8:BDP|9:ZMI|10:TLI|11:CZI|12:SM2|13:NCS
*/

$sectors = [["LECB_CTR", "LECB__CTR", "LECB_W_CTR", "LECB__W_CTR", "LECB_N_CTR", "LECB__N_CTR"],
    ["LECB_C_CTR", "LECB__C_CTR", "LECB_E_CTR", "LECB__E_CTR", "LECB_CTR", "LECB__CTR", "LECB_N_CTR", "LECB__N_CTR"],
    ["LECB_E_CTR", "LECB__E_CTR", "LECB_CTR", "LECB__CTR", "LECB_N_CTR", "LECB__N_CTR"],
    ["LECB_S_CTR", "LECB__S_CTR", "LECB_E_CTR", "LECB__E_CTR", "LECB_CTR", "LECB__CTR"],
    ["LECB_W_CTR", "LECB__W_CTR", "LECB_CTR", "LECB__CTR"],
    ["LECP_CTR"],
    ["LECL_CTR"],
    ["LECM_W_CTR", "LECM__W_CTR", "LECM_N_CTR", "LECM__N_CTR", "LECM_CTR", "LECM__CTR", "LECM_ALL_CTR", "LECM__ALL_CTR"],
    ["LECM_N_CTR", "LECM__N_CTR", "LECM_CTR", "LECM__CTR", "LECM_ALL_CTR", "LECM__ALL_CTR"],
    ["LECM_Z_CTR", "LECM__Z_CTR", "LECM_C_CTR", "LECM__C_CTR", "LECM_CTR", "LECM__CTR", "LECM_ALL_CTR", "LECM__ALL_CTR"],
    ["LECM_C_CTR", "LECM__C_CTR", "LECM_CTR", "LECM__CTR", "LECM_ALL_CTR", "LECM__ALL_CTR"],
    ["LECM_E_CTR", "LECM__E_CTR", "LECM_C_CTR", "LECM__C_CTR", "LECM_CTR", "LECM__CTR", "LECM_ALL_CTR", "LECM__ALL_CTR"],
    ["LECS_W_CTR", "LECS__W_CTR", "LECS_CTR", "LECS__CTR", "LECM_ALL_CTR", "LECM__ALL_CTR"],
    ["LECS_CTR", "LECS__CTR", "LECM_ALL_CTR", "LECM__ALL_CTR"]];

//Others
$LPPC = ["LPPC__CTR", "LPPC_CTR", "LPPC_C_CTR", "LPPC_D_CTR", "LPPC_E_CTR", "LPPC_I_CTR", "LPPC_L_CTR", "LPPC_N_CTR", "LPPC_O_CTR", "LPPC_S_CTR", "LPPC_W_CTR", "EURW_FSS", "EURW__FSS"];
$LFRR = ["LFRR__CTR", "LFRR_CTR", "LFRR_J_CTR", "LFRR_N_CTR", "LFRR_S_CTR", "LFRR_W_CTR", "LFRR_E_CTR", "EURW_FSS", "EURW__FSS"];
$LFBB = ["LFBB__CTR", "LFBB_CTR", "LFBB_UN_CTR", "LFBB_US_CTR", "EURW_FSS", "EURW__FSS"];
$LFMM = ["LFMM__CTR", "LFMM_CTR", "LFMM_E_CTR", "LFMM_N_CTR", "LFMM_S_CTR", "EURW_FSS", "EURW__FSS"];
$DAAA = ["DAAA__CTR", "DAAA_CTR", "DAAA_C_CTR", "DAAA_E_CTR", "DAAA_S_CTR", "DAAA_W_CTR"];
$GMMM = ["GMMM__CTR", "GMMM_CTR", "GMMM_E_CTR", "GMMM_N_CTR", "GMMM_S_CTR"];
$OCA = ["EGGX__CTR", "NAT__FSS", "EGGX_CTR", "NAT_FSS", "EGGX_A_CTR", "EGGX_B_CTR", "EGGX_C_CTR", "EGGX_D_CTR", "EGGX_F_CTR"];

for ($i = 0; $i < sizeof($sectors); $i++) {
    $sectorFound = false;
    $sectorCoverage = "";
    $sectorFreq = "";
    for ($a = 0; $a < sizeof($sectors[$i]); $a++) {
        for ($j = 0; $j < $total; $j++) {
            if (!$sectorFound) {
                if ($obj->controllers[$j]->callsign == $sectors[$i][$a]) {
                    $sectorFound = true;
                    $sectorCoverage = $sectors[$i][$a];
                    $sectorFreq = $obj->controllers[$j]->frequency;
                    switch ($i){
                        case 0:
                            showPPI($sectorCoverage, $sectorFreq);
                            break;
                        case 1:
                            showCCC($sectorCoverage, $sectorFreq);
                            break;
                        case 2:
                            showVNI($sectorCoverage, $sectorFreq);
                            break;
                        case 3:
                            showMVS($sectorCoverage, $sectorFreq);
                            break;
                        case 4:
                            showLLI($sectorCoverage, $sectorFreq);
                            break;
                        case 5:
                            showLECP($sectorCoverage, $sectorFreq);
                            break;
                        case 6:
                            showLECL($sectorCoverage, $sectorFreq);
                            break;
                        case 7:
                            showSAI($sectorCoverage, $sectorFreq);
                            break;
                        case 8:
                            showBDP($sectorCoverage, $sectorFreq);
                            break;
                        case 9:
                            showZMI($sectorCoverage, $sectorFreq);
                            break;
                        case 10:
                            showTLI($sectorCoverage, $sectorFreq);
                            break;
                        case 11:
                            showCZI($sectorCoverage, $sectorFreq);
                            break;
                        case 12:
                            showSM2($sectorCoverage, $sectorFreq);
                            break;
                        case 13:
                            showNCS($sectorCoverage, $sectorFreq);
                            break;
                    }
                }
            }
        }
        $sectorFound = false;
    }
}
function showPPI($sectorCoverage, $sectorFreq){
    ?>
    <script>
        L.polygon([
            [42.7, -0.066667],
            [40.2, -0.9],
            [40.237, -0.017],
            [40.7, 0.15],
            [40.7, 0.5],
            [40.4, 1.05],
            [39.7, 0.6],
            [39.7, 1.8],
            [40.0, 2.2],
            [40.3, 2.09],
            [42.5, 1.7]
        ]).addTo(mymap).bindPopup("<b><?= $sectorCoverage; ?></b> (<?= $sectorFreq; ?>)");
    </script>
    <?php
}

function showCCC($sectorCoverage, $sectorFreq){
    ?>
    <script>
        L.polygon([
            [42.5, 1.7],
            [42.5, 2.9],
            [42.2, 3.9],
            [41.8, 3.7],
            [41.5, 2.9],
            [40.4, 2.9],
            [40.0, 2.2],
            [40.3, 2.09]
        ]).addTo(mymap).bindPopup("<b><?= $sectorCoverage; ?></b> (<?= $sectorFreq; ?>)");
    </script>
    <?php
}
function showVNI($sectorCoverage, $sectorFreq){
    ?>
    <script>
        L.polygon([
            [42.2, 3.9],
            [42.0, 4.4],
            [41.8, 4.1],
            [40.2, 3.6],
            [40.4, 2.9],
            [41.5, 2.9],
            [41.8, 3.7]
        ]).addTo(mymap).bindPopup("<b><?= $sectorCoverage; ?></b> (<?= $sectorFreq; ?>)");
    </script>
    <?php
}
function showMVS($sectorCoverage, $sectorFreq){
    ?>
    <script>
        L.polygon([
            [42.0, 4.4],
            [42.0, 4.6],
            [39.0, 4.6],
            [38.3, 3.7],
            [37.8, 2.1],
            [39.2, 1.7],
            [39.7, 1.8],
            [40.0, 2.2],
            [40.4, 2.9],
            [40.2, 3.6],
            [41.8, 4.1]
        ]).addTo(mymap).bindPopup("<b><?= $sectorCoverage; ?></b> (<?= $sectorFreq; ?>)");
    </script>
    <?php
}
function showLLI($sectorCoverage, $sectorFreq){
    ?>
    <script>
        L.polygon([
            [40.2, -0.9],
            [40.237, -0.017],
            [40.7, 0.15],
            [40.7, 0.5],
            [40.4, 1.05],
            [39.7, 0.6],
            [39.7, 1.8],
            [39.2, 1.7],
            [37.8, 2.1],
            [36.4, -1.0],
            [36.7, -1.53],
            [37.1, -1.8]
        ]).addTo(mymap).bindPopup("<b><?= $sectorCoverage; ?></b> (<?= $sectorFreq; ?>)");
    </script>
    <?php
}
function showLECP($sectorCoverage, $sectorFreq){
    ?>
    <script>
        L.polygon([
            [40.5, 2.358333],
            [40.5, 4.666667],
            [39.716667, 4.666667],
            [38.433333, 1.466667],
            [38.608333, 1.116667],
            [38.608333, 0.675],
            [39.075, 0.675],
            [40.5, 2.358333]
        ]).addTo(mymap).bindPopup("<b><?= $sectorCoverage; ?></b> (<?= $sectorFreq; ?>)");
    </script>
    <?php
}
function showLECL($sectorCoverage, $sectorFreq){
    ?>
    <script>
        L.polygon([
            [40.0,-0.59722],
            [40.233333, -0.41388],
            [40.577778, -0.41388],
            [40.577778, 0.698611],
            [40.231389, 0.698611],
            [39.7725, 0.147778],
            [39.25, 0.483333],
            [38.5, 0.483333],
            [38.0, 0.166667],
            [38.0, -0.33333],
            [38.116667, -0.46666],
            [38.116667, -0.86666],
            [38.833333, -1.33333],
            [39.031389, -1.28],
            [39.15, -1.25],
            [39.566667, -1.65],
            [40.0, -1.366667],
            [40.0, -0.597222]
        ]).addTo(mymap).bindPopup("<b><?= $sectorCoverage; ?></b> (<?= $sectorFreq; ?>)");
    </script>
    <?php
}
//LECM
function showSAI($sectorCoverage, $sectorFreq){
    ?>
    <script>
        L.polygon([
            [41.587, -6.442],
            [42.388, -5.684],
            [44.340, -3.992],
            [45.004, -8.002],
            [45.012, -13.001],
            [43.013, -13.001],
            [41.985, -10.002],
            [41.698, -6.640]
        ]).addTo(mymap).bindPopup("<b><?= $sectorCoverage; ?></b> (<?= $sectorFreq; ?>)");
    </script>
    <?php
}
function showBDP($sectorCoverage, $sectorFreq){
    ?>
    <script>
        L.polygon([
            [42.371, -5.673],
            [42.331, -4.382],
            [41.369, -4.674],
            [41.225, -4.547],
            [40.956, -3.663],
            [41.303, -2.850],
            [41.030, -2.828],
            [41.030, -2.410],
            [42.748, -1.010],
            [42.820, -0.559],
            [43.061, -1.306],
            [43.386, -1.773],
            [43.585, -1.779],
            [44.344, -3.998]
        ]).addTo(mymap).bindPopup("<b><?= $sectorCoverage; ?></b> (<?= $sectorFreq; ?>)");
    </script>
    <?php
}

function showZMI($sectorCoverage, $sectorFreq){
    ?>
    <script>
        L.polygon([
            [39.003, -7.058],
            [39.028, -5.168],
            [40.238, -4.992],
            [40.314, -4.608],
            [41.221, -4.564],
            [41.394, -4.685],
            [42.335, -4.399],
            [42.375, -5.695],
            [41.583, -6.431],
            [41.484, -6.289],
            [39.335, -6.464],
            [39.122, -7.047]
        ]).addTo(mymap).bindPopup("<b><?= $sectorCoverage; ?></b> (<?= $sectorFreq; ?>)");
    </script>
    <?php
}

function showTLI($sectorCoverage, $sectorFreq){
    ?>
    <script>
        L.polygon([
            [39.037, -5.146],
            [39.020, -4.751],
            [38.926, -4.597],
            [39.028, -4.454],
            [39.020, -3.432],
            [40.523, -2.872],
            [41.030, -2.828],
            [41.303, -2.850],
            [40.956, -3.663],
            [41.225, -4.547],
            [41.221, -4.564],
            [40.314, -4.608],
            [40.238, -4.992],
            [39.028, -5.168]
        ]).addTo(mymap).bindPopup("<b><?= $sectorCoverage; ?></b> (<?= $sectorFreq; ?>)");
    </script>
    <?php
}

function showCZI($sectorCoverage, $sectorFreq){
    ?>
    <script>
        L.polygon([
            [39.011, -3.421],
            [39.020, -1.290],
            [42.707, -0.070],
            [42.852, -0.279],
            [42.748, -1.026],
            [41.030, -2.410],
            [41.030, -2.828],
            [40.523, -2.872]
        ]).addTo(mymap).bindPopup("<b><?= $sectorCoverage; ?></b> (<?= $sectorFreq; ?>)");
    </script>
    <?php
}

function showSM2($sectorCoverage, $sectorFreq){
    ?>
    <script>
        L.polygon([
            [35.845, -7.442],
            [35.863, -5.706],
            [36.174, -5.684],
            [36.457, -5.036],
            [36.898, -5.047],
            [36.915, -4.707],
            [37.345, -4.388],
            [37.545, -4.399],
            [37.554, -4.751],
            [39.028, -4.091],
            [39.028, -4.465],
            [38.917, -4.575],
            [39.011, -4.751],
            [39.011, -7.069],
            [36.032, -7.387]
        ]).addTo(mymap).bindPopup("<b><?= $sectorCoverage; ?></b> (<?= $sectorFreq; ?>)");
    </script>
    <?php
}

function showNCS($sectorCoverage, $sectorFreq){
    ?>
    <script>
        L.polygon([
            [35.863, -5.706],
            [35.836, -3.509],
            [35.201, -3.498],
            [35.201, -2.938],
            [35.264, -2.861],
            [35.103, -2.356],
            [35.845, -2.345],
            [35.836, -2.004],
            [35.939, -1.971],
            [36.263, -1.488],
            [36.462, -1.037],
            [36.638, -1.510],
            [37.117, -1.784],
            [37.684, -1.652],
            [37.858, -1.532],
            [37.979, -1.674],
            [38.230, -1.488],
            [39.020, -1.312],
            [39.007, -4.069],
            [37.554, -4.740],
            [37.536, -4.388],
            [37.345, -4.399],
            [36.915, -4.696],
            [36.889, -5.058],
            [36.448, -5.025],
            [36.174, -5.673]
        ]).addTo(mymap).bindPopup("<b><?= $sectorCoverage; ?></b> (<?= $sectorFreq; ?>)");
    </script>
    <?php
}

//BOUNDARY SECTORS
$LPPCFound = false;
for ($i = 0; $i < sizeof($LPPC); $i++) {
    for ($j = 0; $j < $total; $j++) {
        if (!$LPPCFound) {
            if ($obj->controllers[$j]->callsign == $LPPC[$i]) {
                $LPPCFound = true;
            }
        }
    }
}
$LFRRFound = false;
for ($i = 0; $i < sizeof($LFRR); $i++) {
    for ($j = 0; $j < $total; $j++) {
        if (!$LFRRFound) {
            if ($obj->controllers[$j]->callsign == $LFRR[$i]) {
                $LFRRFound = true;
            }
        }
    }
}
$LFBBFound = false;
for ($i = 0; $i < sizeof($LFBB); $i++) {
    for ($j = 0; $j < $total; $j++) {
        if (!$LFBBFound) {
            if ($obj->controllers[$j]->callsign == $LFBB[$i]) {
                $LFBBFound = true;
            }
        }
    }
}
$LFMMFound = false;
for ($i = 0; $i < sizeof($LFMM); $i++) {
    for ($j = 0; $j < $total; $j++) {
        if (!$LFMMFound) {
            if ($obj->controllers[$j]->callsign == $LFMM[$i]) {
                $LFMMFound = true;
            }
        }
    }
}
$DAAAFound = false;
for ($i = 0; $i < sizeof($DAAA); $i++) {
    for ($j = 0; $j < $total; $j++) {
        if (!$DAAAFound) {
            if ($obj->controllers[$j]->callsign == $DAAA[$i]) {
                $DAAAFound = true;
            }
        }
    }
}
$GMMMFound = false;
for ($i = 0; $i < sizeof($GMMM); $i++) {
    for ($j = 0; $j < $total; $j++) {
        if (!$GMMMFound) {
            if ($obj->controllers[$j]->callsign == $GMMM[$i]) {
                $GMMMFound = true;
            }
        }
    }
}
$OCAFound = false;
for ($i = 0; $i < sizeof($OCA); $i++) {
    for ($j = 0; $j < $total; $j++) {
        if (!$LPPCFound) {
            if ($obj->controllers[$j]->callsign == $OCA[$i]) {
                $OCAFound = true;
            }
        }
    }
}

if ($LPPCFound) {
    ?>
    <script>
        var planeIcon = L.icon({
            iconUrl: 'img/controllerStatus/lppc-on.png',
            iconSize: [50, 20]
        });
        L.marker([39.53283857667809, -8.642212450131197], {icon: planeIcon}).addTo(mymap).bindPopup("LPPC ONLINE");
    </script>
    <?php
}else{
    ?>
    <script>
        var planeIcon = L.icon({
            iconUrl: 'img/controllerStatus/lppc-off.png',
            iconSize: [50, 20]
        });
        L.marker([39.53283857667809, -8.642212450131197], {icon: planeIcon}).addTo(mymap).bindPopup("LPPC OFFLINE");
    </script>
    <?php
}

if ($LFRRFound) {
    ?>
    <script>
        var planeIcon = L.icon({
            iconUrl: 'img/controllerStatus/lfrr-on.png',
            iconSize: [50, 20]
        });
        L.marker([45.84482167556384, -5.595788115408225], {icon: planeIcon}).addTo(mymap).bindPopup("LFRR ONLINE");
    </script>
    <?php
}else{
    ?>
    <script>
        var planeIcon = L.icon({
            iconUrl: 'img/controllerStatus/lfrr-off.png',
            iconSize: [50, 20]
        });
        L.marker([45.84482167556384, -5.595788115408225], {icon: planeIcon}).addTo(mymap).bindPopup("LFRR OFFLINE");
    </script>
    <?php
}

if ($LFBBFound) {
    ?>
    <script>
        var planeIcon = L.icon({
            iconUrl: 'img/controllerStatus/lfbb-on.png',
            iconSize: [50, 20]
        });
        L.marker([43.538078565217546, 0.7975481931317071], {icon: planeIcon}).addTo(mymap).bindPopup("LFBB ONLINE");
    </script>
    <?php
}else{
    ?>
    <script>
        var planeIcon = L.icon({
            iconUrl: 'img/controllerStatus/lfbb-off.png',
            iconSize: [50, 20]
        });
        L.marker([43.538078565217546, 0.7975481931317071], {icon: planeIcon}).addTo(mymap).bindPopup("LFBB OFFLINE");
    </script>
    <?php
}

if ($LFMMFound) {
    ?>
    <script>
        var planeIcon = L.icon({
            iconUrl: 'img/controllerStatus/lfmm-on.png',
            iconSize: [50, 20]
        });
        L.marker([41.0358666435354, 6.20515109961766], {icon: planeIcon}).addTo(mymap).bindPopup("LFMM ONLINE");
    </script>
    <?php
}else{
    ?>
    <script>
        var planeIcon = L.icon({
            iconUrl: 'img/controllerStatus/lfmm-off.png',
            iconSize: [50, 20]
        });
        L.marker([41.0358666435354, 6.20515109961766], {icon: planeIcon}).addTo(mymap).bindPopup("LFMM OFFLINE");
    </script>
    <?php
}

if ($DAAAFound) {
    ?>
    <script>
        var planeIcon = L.icon({
            iconUrl: 'img/controllerStatus/daaa-on.png',
            iconSize: [50, 20]
        });
        L.marker([37.266719516865074, 1.8106916184962591], {icon: planeIcon}).addTo(mymap).bindPopup("DAAA ONLINE");
    </script>
    <?php
}else{
    ?>
    <script>
        var planeIcon = L.icon({
            iconUrl: 'img/controllerStatus/daaa-off.png',
            iconSize: [50, 20]
        });
        L.marker([37.266719516865074, 1.8106916184962591], {icon: planeIcon}).addTo(mymap).bindPopup("DAAA OFFLINE");
    </script>
    <?php
}

if ($GMMMFound) {
    ?>
    <script>
        var planeIcon = L.icon({
            iconUrl: 'img/controllerStatus/gmmm-on.png',
            iconSize: [50, 20]
        });
        L.marker([33.64095833354265, -6.292864896834501], {icon: planeIcon}).addTo(mymap).bindPopup("GMMM ONLINE");
    </script>
    <?php
}else{
    ?>
    <script>
        var planeIcon = L.icon({
            iconUrl: 'img/controllerStatus/gmmm-off.png',
            iconSize: [50, 20]
        });
        L.marker([33.64095833354265, -6.292864896834501], {icon: planeIcon}).addTo(mymap).bindPopup("GMMM OFFLINE");
    </script>
    <?php
}

if ($OCAFound) {
    ?>
    <script>
        var planeIcon = L.icon({
            iconUrl: 'img/controllerStatus/oca-on.png',
            iconSize: [40, 20]
        });
        L.marker([43.48265812564574, -15.093253133043753], {icon: planeIcon}).addTo(mymap).bindPopup("OCA ONLINE");
    </script>
    <?php
}else{
    ?>
    <script>
        var planeIcon = L.icon({
            iconUrl: 'img/controllerStatus/oca-off.png',
            iconSize: [40, 20]
        });
        L.marker([43.48265812564574, -15.093253133043753], {icon: planeIcon}).addTo(mymap).bindPopup("OCA OFFLINE");
    </script>
    <?php
}

?>
