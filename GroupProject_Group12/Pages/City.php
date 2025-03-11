<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="/Group_Project/GroupProject_Group12/style.css">

    <!-- chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="/Group_Project/GroupProject_Group12/scripts/sidebar.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/graph.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/darkmode.js"></script>

    <title>City Council - Smart Energy Dashboard</title>
</head>

<body>
  
    <!-- Navbar -->
    <?php include("../navbar.php"); ?>

    <div id="testing" style="margin-left: 48px;">

        <div style="text-align: center">
            <h2 style="color: white">City Name:</h2>
        </div>

        <div class="btn-group" style = "margin-top: 25px; margin-left: 15px;" role = "group" >
            <button type = "button" class="btn btn-primary">Stedin</button>
            <button type = "button" class="btn btn-primary">Liander</button>
            <button type = "button" class="btn btn-primary">Coteq</button>
            <button type = "button" class="btn btn-primary">Enduris</button>
            <button type = "button" class="btn btn-primary">Rendo</button>
            <button type = "button" class="btn btn-primary">Westlandinfra</button>
            <button type = "button" class="btn btn-primary">Enexis</button>
        </div>

        <div style="color" class="panel-group">
            <div style="margin-top: 25px;" class="panel panel-default">

                <div class="panel-heading">Panel</div>
                <div class="panel-body"><canvas id="myChart" style="width:100%;max-width:700px"></canvas></div>
        
            
            </div>
        </div>

    </div>

    <script>
        var xyValues = [
        {x:50, y:7},
        {x:60, y:8},
        {x:70, y:8},
        {x:80, y:14},
        {x:90, y:9},
        {x:100, y:9},
        {x:110, y:10},
        {x:120, y:11},
        {x:130, y:14},
        {x:140, y:14},
        {x:150, y:15}
        ];

        const data = {
            labels: ["2014","2015","2016","2017","2018"],
            datasets: [{
                label: "Electricity Usage (kWh)",
                data: xyValues,
                fill: "false",
                borderColor: "rgb(75,192,192)",
                tension: 0.1,
            }]
        };

        new Chart("myChart", {
        type: "line",
        data: data,
        options: {
            legend: {display: false},
            scales: {
            xAxes: [{ticks: {min: 40, max:160}}],
            yAxes: [{ticks: {min: 6, max:16}}],
            }
        }
        });


        
</script>
</body>




</html>