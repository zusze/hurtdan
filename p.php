<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="UTF-8" />
</head>
<body>
<?php

	echo "Hello World";

          $connect = new mysqli("localhost", "root", "", "projekt_hd"); //polaczenie do bazy
          if (mysqli_connect_errno()) {
            echo "Blad polaczenia do bazy MySQL: " . mysqli_connect_error();
            exit();
          }
          $filename = "zakopane.json";
          $data = file_get_contents($filename); //ladowanie pliku json do php
          $array = json_decode($data, true); //konwertowanie jsona do tabeli php
          foreach($array as $row) //wyciaganie daych z tabeli i insertowanie do tabeli
          {
           $sql= "INSERT INTO opinie(hotel,publish_date,rev_count,rating,tags) VALUES ('".$row["hotel"]."', '".$row["publish_date"]."', '".$row["rev_count"]."', '".$row["rating"]."',, '".$row["tags"]."');";  // insert danych
           }
		   if(mysqli_query($connect, $sql)); //Run Mutliple Insert Query
		   {
			echo "Proces ETL skonczony";
		   }
	
?>
</body>
</html>
