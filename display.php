<?php
    error_reporting(E_ALL & ~E_NOTICE);
    $host = "localhost";
    $user = "root";
    $pass = "";
    $start_date = $_POST["min"];
    $end_date = $_POST["max"];
    $type = $_POST["type"];
    $basis1 = $_POST['data'][0];
    $basis2 = $_POST['data'][1];
    $basis3 = $_POST['data'][2];
    
    if($basis1 == NULL) {
        echo "<script>alert('Select Valid Query')</script>";
        return ;
    }
    $no_of_q = 0;

    $connect= mysqli_connect($host,$user,$pass,"temp_data") or die(mysql_error());
    
    if($basis2 != NULL){$no_of_q = 1;}
    if($basis3 != NULL){$no_of_q = 2;}

    if($no_of_q >= 0){
    $sql_q0 = "SELECT ".$basis1."(".$type.") as ans FROM data_set WHERE DATE(Date) >= ' ".$start_date." ' AND DATE(Date) <= '".$end_date." ';"; 
    $result = mysqli_query($connect,$sql_q0);
    echo "<center><p style=\"background-color:white; width: 800px\">Results Shown For: ".$basis1." of ".$type." From: ".$start_date." to ".$end_date."</center>";
    if ($result !== false) {
    if($result->num_rows == 1){
        while($row = $result->fetch_assoc()){
                $res0 = $row["ans"];
                echo "<center><p>".$row["ans"]."</p></center> ";
            }
        }
    }
    $sql3_q0 = "SELECT ".$basis1."(".$type.") as totans FROM data_set";
    $compare_q0 = mysqli_query($connect,$sql3_q0);
    if($compare_q0->num_rows > 0){
            while($row3 = $compare_q0->fetch_assoc()){
                $res_tq0 = $row3["totans"];
            }
    }
    }

    if($no_of_q >= 1){
    $sql_q1 = "SELECT ".$basis2."(".$type.") as ans FROM data_set WHERE DATE(Date) >= ' ".$start_date." ' AND DATE(Date) <= '".$end_date." ';"; 
    //echo $sql;
    $result = mysqli_query($connect,$sql_q1);
    echo "<center><p style=\"background-color:white; width: 800px\">Results Shown For: ".$basis2." of ".$type." From: ".$start_date." to ".$end_date."</center>";
    if ($result !== false) {
    if($result->num_rows == 1){
        while($row = $result->fetch_assoc()){
                $res1 = $row["ans"];
                echo "<center><p>".$row["ans"]."</p></center> ";
            }
        }
    }
    $sql3_q1 = "SELECT ".$basis2."(".$type.") as totans FROM data_set";
    $compare_q1 = mysqli_query($connect,$sql3_q1);
    if($compare_q1->num_rows > 0){
            while($row3 = $compare_q1->fetch_assoc()){
                $res_tq1 = $row3["totans"];
            }
    }
    }

    if($no_of_q == 2){
    $sql_q2 = "SELECT ".$basis3."(".$type.") as ans FROM data_set WHERE DATE(Date) >= ' ".$start_date." ' AND DATE(Date) <= '".$end_date." ';";
    //echo $sql;
    $result = mysqli_query($connect,$sql_q2);
    echo "<center><p style=\"background-color:white; width: 800px\">Results Shown For: ".$basis3." of ".$type." From: ".$start_date." to ".$end_date."</center>";
    if ($result !== false) {
    $x = mysqli_fetch_field($result);
    if($result->num_rows == 1){
        while($row = $result->fetch_assoc()){
                $res2 = $row["ans"];
                echo "<center><p>".$row["ans"]."</p></center> ";
            }
        }
    }
    $sql3_q2 = "SELECT ".$basis3."(".$type.") as totans FROM data_set";
    $compare_q2 = mysqli_query($connect,$sql3_q2);
    if($compare_q2->num_rows > 0){
            while($row3 = $compare_q2->fetch_assoc()){
                $res_tq2 = $row3["totans"];
            }
    }
    }

    $i = 0;
    $sql2 = "SELECT Date,".$type." as Answer FROM data_set WHERE DATE(Date) >= '".$start_date."' AND DATE(Date) <= '".$end_date."';";
    $result2 = mysqli_query($connect,$sql2);

    $sql4 = "SELECT Sum(".$type.") as tot_sum From data_set";
    $sum_data = mysqli_query($connect,$sql4);
    
    $sql5 = "SELECT Sum(".$type.") as sum_given From data_set WHERE DATE(Date) >= ' ".$start_date." ' AND DATE(Date) <= '".$end_date." ';"; 
    $sum_given = mysqli_query($connect,$sql5);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Massive Electronics</title>
</head>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
              google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        var data = google.visualization.arrayToDataTable([
          <?php
            echo "['Date', '".$type."'],";
            if($result2->num_rows > 0){
            while($row2 = $result2->fetch_assoc()){
                echo "['".$row2["Date"]."',".$row2["Answer"]."],";
                }
            }
        ?>
        ]);
        var options = {
          title: 'Status for the Period',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
    google.charts.load('current', {packages:['bar']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
          ['Mode of Measurement','Overall','In Range'],
          <?php
            if($no_of_q >= 0){
                echo "['".$basis1."',".$res_tq0.",".$res0."]";
            }
            if($no_of_q >= 1){
                echo ",['".$basis2."',".$res_tq1.",".$res1."]";
            }
            if($no_of_q == 2){
                echo ",['".$basis3."',".$res_tq2.",".$res2."]";
            }
            ?>
      ]);
    
      var options = {
        chart: {
        title: "Comparision with the Overall",
        }
      };
      var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
      chart.draw(data, google.charts.Bar.convertOptions(options));
  }
  </script>
      <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
          var data = google.visualization.arrayToDataTable([
            <?php
            echo "['".$type."','".$Quantity."'],";
            if($sum_data->num_rows > 0){
            while($row4 = $sum_data->fetch_assoc()){
                $data_1 = $row4["tot_sum"];
                }
            }
            if($sum_given->num_rows > 0){
            while($row5 = $sum_given->fetch_assoc()){
                $data_2 = $row5["sum_given"];
                }
            }
            echo "['Given Days',".$data_2."],";
            echo "['Overall',".$data_1."],";
            ?>
        ]);

        var options = {
          title: 'Proportion with respect to total',
          pieHole: 0.4,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>

<body>
    <div class="container-fluid col-12 col-offset-1" id="curve_chart" style="width: 1650px; height: 1000px;"></div>
    <br><br>
    <div class="row container-fluid">
    <div class="container-fluid col-6" id="columnchart_material" style="width: 900px; height: 300px;"></div>
    <div class="container-fluid col-6" id="donutchart" style="width: 900px; height: 300px;"></div>
    </div>
    <br><br><br><br><br><br><br>
    <div class="container-fluid">
        <center><button onclick="printfunction()">Print this page</button></center>
    </div>
    <script>
    function printfunction() {
        window.print();
    }
</script>
</body>
</html>