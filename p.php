<?php
          $connect = mysqli_connect("localhost", "root", "", "test"); //polaczenie do bazy
          $filename = "zakopane.json";
          $data = file_get_contents($filename); //ladowanie pliku json do php
          $array = json_decode($data, true); //konwertowanie jsona do tabeli php
          foreach($array as $row) //wyciaganie daych z tabeli i insertowanie do tabeli
          {
           $sql= "INSERT INTO opinie(hotel,publish_date,rev_count,rating,tags) VALUES ('".$row["hotel"]."', '".$row["publish_date"]."', '".$row["rev_count"]."', '".$row["rating"]."',, '".$row["tags"]."'); ";  // insert danych
           mysqli_query($connect, $sql)) //Run Mutliple Insert Query
           }
    echo "Proces ETL skonczony"
    ?>
