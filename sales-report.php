<?php
    include 'backend.php';
    include 'sellerheader.php';
    $backend = new Backend;
    $backend->checksession();
    $sales = new Sales;

    if (isset($_POST['searchbtn'])) {
        $date = $_POST['month'];
        $dateCon = date("M Y",strtotime($date));
        $input = explode('-',$date);
        $year = $input[0];
        $month = $input[1];
        $sold = $sales->salesReport($month,$year);
    }else{
        $date = date("M Y",strtotime('today'));
        $input = [];
        $year = [];
        $month = [];
        $sold  = "";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
</head>
<body>
    <div class="container">
        <div class="row g-3 p-2">
            <div class="col-12 text-center p-2 bg-warning bg-gradient rounded-5 shadow">
                <h1><i class="bi bi-cash-stack"> Sales Report</i></h1>
            </div>
            <div class="col-md-1">
                <a href="dashboard.php" class="btn btn-info"><i class="bi bi-arrow-bar-left"> Back</i></a>
            </div>
                <div class="col-md-3">
                    <form action="" method="post">
                    <div class="input-group">
                        <span class="input-group-text">Month</span>
                        <input type="month" name="month" min="2023-01" value="2023-04" class="form-control"><br>
                        <button type="submit" name="searchbtn" value="true" class="btn btn-success">Search</button>
                    </div>   
                </div>
                <div class="col-12 shadow rounded p-2">
                    <div id="chart_div" style="width: 100%; height: 500px;"></div>
                    
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Week', 'Sales'],
      ['Week 1', 100],
      ['Week 2', 500],
      ['Week 3', 100],
      ['Week 4', 500],

    ]);

    var options = {
      title: 'Sales Report',
      curveType: 'function',
      legend: { position: 'bottom' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

    chart.draw(data, options);
  }
</script>

</body>
</html>