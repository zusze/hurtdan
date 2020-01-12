<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="palmtree1.png" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
<form action="projekt.php">
        <input type="text" name="tXt" />
        <input type="submit" class="button"  name="extract" value="extract"/>
        <input type="submit" class="button"  name="transform" value="transform"/>
        <input type="submit" class="button"  name="load" value="load"/>
        <input type="submit" class="button"  name="ETL" value="ETL"

<?php
if($_GET){
    if(extract($_GET['extract'])){
        extract();
    }
    elseif(transform($_GET['transform'])){
        transform();
    }
    elseif(load($_GET['load'])){
        load();
    }
    elseif(ETL($_GET['ETL'])){
        ETL();
    }    
}

/*function extract (){
    echo "The extract function is called.";
}
function transform (){
    echo "The transform function is called.";
}
function load (){
    echo "The extrloadact function is called.";
}
function ETL (){
    echo "The ETL function is called.";
}*/
?>
