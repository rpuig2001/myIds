<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<html>
<table class="table">
    <tr>
        <th style="color:white">FIR</th>
        <th style="color:white">Airport</th>
        <th style="color:white">id</th>
        <th style="color:white">Content</th>
        <th style="color:white">Validity</th>
        <th style="color:white"></th>
    </tr>
<?php
//LECB FIR DATA
$json = file_get_contents('https://notams.vatsimspain.es/data.php?fir=LECB');
$obj = json_decode($json);
$total = count($obj->LECB);
for ($i = 0; $i<$total; $i++){
$id = $obj->LECB[$i]->id;$airport = $obj->LECB[$i]->airport;$content = $obj->LECB[$i]->content;$link = $obj->LECB[$i]->link;
$start = $obj->LECB[$i]->start;$end = $obj->LECB[$i]->validity;$fir = $obj->LECB[$i]->fir;
?>
<tr>
    <td style="color:white; font-size: 12px"><b><?php echo $fir;?></b></td><td style="color:white; font-size: 12px"><?php echo $airport;?></td>
    <td style="color:white; font-size: 12px"><b><?php echo $id;?></b></td><td style="color:white; font-size: 12px"><?php echo $content;?></td>
    <?php
    $date_now = date("Y-m-d");
    $date_notam = $end;
    if ($date_notam == 'PERMANENT'){
        ?>
        <td style="color:darkorange; font-size: 12px"><?php echo $start." - PERMANENT";?></td>
        <?php
    }else if ($date_now > $date_notam ){
        ?>
        <td style="color:red; font-size: 12px">EXPIRED</td>
        <?php
    }else{
        ?>
        <td style="color:green; font-size: 12px"><?php echo $start." - ".$end;?></td>
        <?php
    }
    ?>
    <td style="font-size: 12px"><a href=<?php echo $link;?>>More Info</a></td>
    <?php
    }
    ?>
</tr>
<?php
//LECM FIR DATA
$json = file_get_contents('https://notams.vatsimspain.es/data.php?fir=LECM');
$obj = json_decode($json);
$total = count($obj->LECM);
for ($i = 0; $i<$total; $i++){
$id = $obj->LECM[$i]->id;$airport = $obj->LECM[$i]->airport;$content = $obj->LECM[$i]->content;$link = $obj->LECM[$i]->link;
$start = $obj->LECM[$i]->start;$end = $obj->LECM[$i]->validity;$fir = $obj->LECM[$i]->fir;
?>

<tr>
    <td style="color:white; font-size: 12px"><b><?php echo $fir;?></b></td><td style="color:white; font-size: 12px"><?php echo $airport;?></td>
    <td style="color:white; font-size: 12px"><b><?php echo $id;?></b></td><td style="color:white; font-size: 12px"><?php echo $content;?></td>
    <?php
    $date_now = date("Y-m-d");
    $date_notam = $end;
    if ($date_notam == 'PERMANENT'){
        ?>
        <td style="color:darkorange; font-size: 12px"><?php echo $start." - PERMANENT";?></td>
        <?php
    }else if ($date_now > $date_notam ){
        ?>
        <td style="color:red; font-size: 12px">EXPIRED</td>
        <?php
    }else{
        ?>
        <td style="color:green; font-size: 12px"><?php echo $start." - ".$end;?></td>
        <?php
    }
    ?>
    <td style="font-size: 12px"><a href=<?php echo $link;?>>More Info</a></td>
    <?php
    }
    ?>
</tr>
<?php
//GCCC FIR DATA
$json = file_get_contents('https://notams.vatsimspain.es/data.php?fir=GCCC');
$obj = json_decode($json);
$total = count($obj->GCCC);
for ($i = 0; $i<$total; $i++){
$id = $obj->GCCC[$i]->id;$airport = $obj->GCCC[$i]->airport;$content = $obj->GCCC[$i]->content;$link = $obj->GCCC[$i]->link;
$start = $obj->GCCC[$i]->start;$end = $obj->GCCC[$i]->validity;$fir = $obj->GCCC[$i]->fir;
?>

<tr>
    <td style="color:white; font-size: 12px"><b><?php echo $fir;?></b></td><td style="color:white; font-size: 12px"><?php echo $airport;?></td>
    <td style="color:white; font-size: 12px"><b><?php echo $id;?></b></td><td style="color:white; font-size: 12px"><?php echo $content;?></td>
    <?php
    $date_now = date("Y-m-d");
    $date_notam = $end;
    if ($date_notam == 'PERMANENT'){
        ?>
        <td style="color:darkorange; font-size: 12px"><?php echo $start." - PERMANENT";?></td>
        <?php
    }else if ($date_now > $date_notam ){
        ?>
        <td style="color:red; font-size: 12px">EXPIRED</td>
        <?php
    }else{
        ?>
        <td style="color:green; font-size: 12px"><?php echo $start." - ".$end;?></td>
        <?php
    }
    ?>
    <td style="font-size: 12px"><a href=<?php echo $link;?>>More Info</a></td>
    <?php
    }
    ?>
</tr>
</table>
</html>