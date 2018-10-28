<?php
    session_start();
    error_reporting(E_ALL & ~E_NOTICE);
    $host = "localhost";
    $user = "root";
    $pass = "";
    $start_date = $_POST["min"];
    $end_date = $_POST["max"];
    $type = $_POST["type"];
    $basis1 = $_POST["data1"];
    $basis2 = $_POST["data2"];
    $basis3 = $_POST["data3"];
    $db = $_SESSION["DB"];
    $Table = $_SESSION["TB"];
    $connect=new mysqli($host,$user,$pass,"temp_data") or die(mysql_error());
//    echo "jbjbjbjbj";
    //echo "jnjnjnjnjnjnjnjnjn";
    $sql = "SELECT MAX(Temperature) as mx FROM data_set WHERE ";    
    $result = $connect->query($sql);
    if($result->num_rows > 0){
        $x = $result->fetch_assoc();
        echo "temp ".$x['mx'];
    }
    $connect->close();
?>