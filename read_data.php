<?php
    session_start();
    error_reporting(E_ALL & ~E_NOTICE);
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "temp_data";
    $Table = "data_set";
    $_SESSION["DB"] = $db;
    $_SESSION["TB"] = $Table; 
    $connect1 = new mysqli($host,$user,$pass);
    if($connect1->connect_error){
        die("Connection failed: " . $connect1->connect_error);
    }
    //echo "jjj";
    $drop_query = "DROP DATABASE IF EXISTS ".$db;
    $connect1->query($drop_query);
    $sql = "CREATE DATABASE ".$db;
    $connect1->query($sql);
    $connect1->close();

    $connect2 = new mysqli($host,$user,$pass,$db);

    if (!$connect2) {
    die("Connection failed: " . mysqli_connect_error());
    }

    $create_table = "CREATE TABLE ".$Table."(
    id int(6) unsigned auto_increment primary key,
    Date datetime not null,
    Temperature float(10,2) null,
    Relative_Humidity float(10,2) null,
    Pressure float(10,2) null,
    Rain float(10,2) null,
    Light_Intensity int(10) null
    );";

    mysqli_query($connect2, $create_table);
    
    mysqli_close($connect2);
    $connect=new mysqli($host,$user,$pass,$db) or die(mysql_error());
    $data_set = fopen("WeatherDataCS207.csv", "r") or die("Unable to open");
    $take_data = fgetcsv($data_set, 10000, ",");
    while(($take_data = fgetcsv($data_set, 10000, ",")) !== FALSE){
        $insert_query = "INSERT INTO data_set(Date, Temperature, Relative_Humidity, Pressure, Rain, Light_Intensity) values('$take_data[0]','$take_data[1]','$take_data[2]','$take_data[3]','$take_data[4]','$take_data[5]')";
        //echo $insert_query;
        $connect->query($insert_query);
    }
    echo "<center><a href=\"log.html\"><img src=\"img\\click.gif\" style = \" height: 100px\"></a><center>";
    fclose($data_set);
?>