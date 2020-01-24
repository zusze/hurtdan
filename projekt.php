<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="palmtree1.png" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <style>     
        
        .center {    
            position: absolute;
            right: 550px; 
            width: 20%;     
             } 
        .middle{position: absolute;
            right: 500px; 
            width: 17%; 
            top: 150px;}
        
        h1 {
              text-shadow: 3px 2px white;} 
        
        </style>
</head>
<body style="background-color: lightblue;">
<form action="projekt.php" method="POST">
        <input type="text" name="tXt" />
        <input type="submit" class="btn btn-default"  name="extract" value="extract"/>
        <input type="submit" class="btn btn-default"  name="transform" value="transform"/>
        <input type="submit" class="btn btn-default"  name="load" value="load"/>
        <input type="submit" class="btn btn-default"  name="ETL" value="ETL"

<?php
      $connect = new mysqli("localhost", "root", "", "projekt_hd"); //polaczenie do bazy
      if (mysqli_connect_errno()) {
      echo "Blad polaczenia do bazy MySQL: " . mysqli_connect_error();
      exit();                   
      }        

  if($_POST['load']){
    $filename = "zakopane.json";
    $data = file_get_contents($filename); //ladowanie pliku json do php
    $array = json_decode($data, true); //konwertowanie jsona do tabeli php
    foreach($array as $row) //wyciaganie daych z tabeli i insertowanie do tabeli
    {
     $sql= mysqli_query("INSERT INTO opinie(hotel,publish_date,rev_count,rating,tags) VALUES ('".$row["hotel"]."', '".$row["publish_date"]."', '".$row["rev_count"]."', '".$row["rating"]."',, '".$row["tags"]."');");  // insert danych 
    }
  }     

/*To są funkcje napisane tak jakby każdy proces miał byc wywoływany z osobnego pliku:
if($_GET){
    if(extract($_GET['extract'])){
        extract();
    }
    elseif(isset($_GET['transform'])){
        transform();
    }
    elseif(isset($_GET['load'])){
        load();
    }
    elseif(isset($_GET['ETL'])){
        ETL();
    }    
}

function extract (){
    echo "The extract function is called.";
}
function transform (){
    echo "The transform function is called.";
}
function load (){
    echo "The load function is called.";
    $filename = "zakopane.json";
    $data = file_get_contents($filename); //ladowanie pliku json do php
    $array = json_decode($data, true); //konwertowanie jsona do tabeli php
    foreach($array as $row) //wyciaganie daych z tabeli i insertowanie do tabeli
    {
     $sql= mysqli_query("INSERT INTO opinie(hotel,publish_date,rev_count,rating,tags) VALUES ('".$row["hotel"]."', '".$row["publish_date"]."', '".$row["rev_count"]."', '".$row["rating"]."',, '".$row["tags"]."');");  // insert danych 
    }
}
function ETL (){
    echo "The ETL function is called.";
}*/
?>
               
</form>
    </body>
    </html>
