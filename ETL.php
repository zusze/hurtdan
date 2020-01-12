<?php
$link = mysqli_connect("localhost","root","projekt_hd") or 
die(mysqli_connect_error());

if($_POST['ETL']){
    $filename = "zakopane.json";
    $data = file_get_contents($filename); //ladowanie pliku json do php
    $array = json_decode($data, true); //konwertowanie jsona do tabeli php
    foreach($array as $row) //wyciaganie daych z tabeli i insertowanie do tabeli
    {
     $sql= mysqli_query("INSERT INTO opinie(hotel,publish_date,rev_count,rating,tags) VALUES ('".$row["hotel"]."', '".$row["publish_date"]."', '".$row["rev_count"]."', '".$row["rating"]."',, '".$row["tags"]."');");  // insert danych 
    }
  }
?>
