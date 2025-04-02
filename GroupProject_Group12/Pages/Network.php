<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>
    
    <title>Network - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- 📍 Navbar -->
    <?php include("../modules/navbar.php");
    require('../Database_Php_Interactions/Database_Utilities.php');
    include('../Database_Php_Interactions/CSVData.php'); ?>
    
    <!-- 🌐 Network page content -->
    <div class="container mt-4">
        
        <!-- 📛 Title -->
        <div class="text-center">
            <h2><?php 
            debug_to_console($RoleID);
            switch ($RoleID) {
            case '1' :
                echo 'Admin User';
                break; 
            case '2' : 
                echo $RoleNetwork;
                break;
            
                }?></h2>
        </div>
        


        <?php 
            $Network = $RoleNetwork;
            $Types = ['Gas', 'Electricity'];
            $Year = '2016';
            $NetworkValueByType = array('Gas' => [] , 'Electricity' => []);
            
            foreach ($Types as $Type) {
                $NetworkValue = CSVData($Type, $Year, $Network);

                foreach ($NetworkValue as $City => $Data) {
                    debug_to_console($City);
                    if (!isset($TotalNetworkConsume[$City])) {
                        $TotalNetworkConsume[$City] = 0;
                    }
                    
                    $TotalNetworkConsume[$City] += $Data[0];
                }
                $NetworkValueByType[$Type] = $TotalNetworkConsume;
            }
            
        ?>


        <div class ="row">
            
            <div class="card">
                <div class="card-header">City Chart for Network : <?php echo $RoleNetwork ?></div>
                <div class="card-body">
                    <form action="Network.php" method = 'POST'>
                        <div class="themed-dropdown" style = 'float : left'>
                            <label for="TypeFilter">Filter by Type:</label>
                            <select id="TypeFilter" name='TypeFilter'>
                                <option value="Gas">Gas</option>
                                <option value="Electricity">Electricity</option>
                            </select>
                        </div>
                        <button type="Submit" class="fancy-button" style = 'margin-top : 15px; float: right;'>
                            Apply Filter
                        </button>
                    </form>
                    <canvas id="cityChart" width="400px" height="150px"></canvas>
                    <script>
                    
                        
                        var data = <?php 
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['TypeFilter'])) {
                            echo json_encode($NetworkValueByType[$_POST['TypeFilter']]);
                        } else {
                            echo json_encode($NetworkValueByType['Gas']); 
                        }
                        ?>;
                        console.log(data);
                        
                        const ctx = document.getElementById('cityChart').getContext('2d');
                        let cityChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: Object.keys(data),
                                datasets: [{
                                    label: 'City Data',
                                    data: Object.values(data),
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            color: 'white' // 📏 Y-axis text color
                                        }
                                    },
                                    x: {
                                        ticks: {
                                            color: 'white' // 📏 X-axis text color
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        labels: {
                                            color: 'white' // 🏷️ Legend text color
                                        }
                                    }
                                }
                            }
                        });

                        function filterData() {
                            const selectedCity = document.getElementById('cityFilter').value;
                            cityChart.data.datasets[0].data = data[selectedCity];
                            cityChart.update();
                        }
                    </script>
                </div>
            </div>
            
            <div class="col-12 col-md-7">
                <div class="card" style="height: 90%">
                    <div class="card-header">Additional Information</div>
                    <div class="card-body">
                        <div id = "SummaryContent">Number of Connections: </div>
                        <div id = "SummaryContent">Amount of Electricity Used (kWh): </div>
                        <div id = "SummaryContent">Amount of Gas Used (m<sup>3</sup>): </div>
                        <div id = "SummaryContent">Delivery Percentage: </div>
                        <div id = "SummaryContent">Types of Connections: </div>
                        <div id = "SummaryContent">Types Connections Percentage: </div>
                        <button type="button" class="fancy-button" style="float: right">Print Summary</button>
                    </div>
                </div> 
            </div>
            
            <div class="col-12 col-md-5">
                <div class="card" style="height: 90%">
                    <div class="card-header">Filter Options:</div>
                    <div class="card-body">
                        
                        <div id="SummaryContent" class="themed-dropdown">Filter report by city: 
                            <select id="ReportCityFilterNetwork"> 
                                <option value="all">All</option>
                                <?php 
                                    include('../Database_Php_Interactions/CitySelect.php');
                                ?>
                            </select>
                        </div>
                        
                        <div id="SummaryContent" class="themed-dropdown">Filter report by utility: 
                            <select id="Gas_Electricity_Both"> 
                                <option value="Both">All</option>
                                <option value="Gas">Gas</option>
                                <option value="Electricity">Electricity</option>
                            </select>
                        </div> 
                        
                        <div id = "SummaryContent">
                            <button type="button" class="fancy-button" style="float: right">Print Summary</button>
                        </div>
                    </div>
                </div> 
            </div>
            
            <!-- 🗺️ Heatmap -->
            <div class="col-12 col-md-12">
                <div class="card" style="height: 90%">
                    <div class="card-header">🗺️ Energy Use Heatmap</div>
                    <div id="heatmap" style="height: 500px;">
                        <!-- 🗺️ Heatmap container -->
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
</body>
</html>