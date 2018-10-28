<?php
    session_start();
    error_reporting(E_ALL & ~E_NOTICE);
    $host = "localhost";
    $user = "root";
    $pass = "";
    $first_date = $_POST["min"];
    $second_date = $_POST["max"];
    $type = $_POST["type"];
    $db = $_SESSION["DB"];
    $Table = $_SESSION["TB"];
    
    $connect= mysqli_connect($host,$user,$pass,"temp_data") or die(mysql_error());
    
    $sql_q0 = "SELECT MAX(".$type.") as ans FROM data_set WHERE DATE(Date) = ' ".$first_date." ';"; 
    $result = mysqli_query($connect,$sql_q0);
    if ($result !== false) {
    if($result->num_rows == 1){
        while($row = $result->fetch_assoc()){
                $res0_0 = $row["ans"];
            }
        }
    }
    $sql_q0 = "SELECT MAX(".$type.") as ans FROM data_set WHERE DATE(Date) = ' ".$second_date." ';"; 
    $result = mysqli_query($connect,$sql_q0);
    if ($result !== false) {
    if($result->num_rows == 1){
        while($row = $result->fetch_assoc()){
                $res0_1 = $row["ans"];
            }
        }
    }
    $sql_q0 = "SELECT MIN(".$type.") as ans FROM data_set WHERE DATE(Date) = ' ".$first_date." ';"; 
    $result = mysqli_query($connect,$sql_q0);
    if ($result !== false) {
    if($result->num_rows == 1){
        while($row = $result->fetch_assoc()){
                $res1_0 = $row["ans"];
            }
        }
    }
    $sql_q0 = "SELECT MIN(".$type.") as ans FROM data_set WHERE DATE(Date) = ' ".$second_date." ';"; 
    $result = mysqli_query($connect,$sql_q0);
    if ($result !== false) {
    if($result->num_rows == 1){
        while($row = $result->fetch_assoc()){
                $res1_1 = $row["ans"];
            }
        }
    }
    $sql_q0 = "SELECT AVG(".$type.") as ans FROM data_set WHERE DATE(Date) = ' ".$first_date." ';"; 
    $result = mysqli_query($connect,$sql_q0);
    if ($result !== false) {
    if($result->num_rows == 1){
        while($row = $result->fetch_assoc()){
                $res2_0 = $row["ans"];
            }
        }
    }
    $sql_q0 = "SELECT AVG(".$type.") as ans FROM data_set WHERE DATE(Date) = ' ".$second_date." ';"; 
    $result = mysqli_query($connect,$sql_q0);
    if ($result !== false) {
    if($result->num_rows == 1){
        while($row = $result->fetch_assoc()){
                $res2_1 = $row["ans"];
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Massive Electronics</title>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    alert("In case of missing graph - Data not Available");
    google.charts.load('current', {packages:['bar']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart(){
      var data = google.visualization.arrayToDataTable([
          ['Mode of Measurement','Overall','In Range'],
          <?php
                echo "['MAX',".$res0_0.",".$res0_1."]";
                echo ",['MIN',".$res1_0.",".$res1_1."]";
                echo ",['AVG',".$res2_0.",".$res2_1."]";
            ?>
      ]);
    
      var options = {
        chart: {
        title: "Comparision",
        }
      };
      var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
      chart.draw(data, google.charts.Bar.convertOptions(options));
  }
  </script>
</head>
<body>
  <div class="container-fluid col-12 col-offset-1" id="columnchart_material" style="width: 1650px; height: 1000px;"></div>
<script>
    function printfunction() {
        window.print();
    }
</script>
</body>
</html>