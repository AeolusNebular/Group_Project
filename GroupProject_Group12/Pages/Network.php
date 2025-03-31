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
            <h2>Network</h2>
        </div>
        <div class ="row">
            <div class="themed-dropdown">
                <label for="cityFilter">Filter by city:</label>
                <select id="cityFilter" onchange="filterData()">
                    <option value="all">All</option>
                    <option value="Enexis">Enexis</option>
                    <option value="Liander">Liander</option>
                    <option value="Stedin">Stedin</option>
                    <option value="Enduris">Enduris</option>
                    <option value="Westlandinfra">Westlandinfra</option>
                    <option value="Rendo">Rendo</option>
                    <option value="Coteq">Coteq</option>
                    <!-- Add more cities as needed -->
                </select>
            </div>
            <div class="card">
                <div class="card-header">City Chart for Network</div>
                <div class="card-body">
                    <canvas id="cityChart" width="400px" height="150px"></canvas>
                    <script>
                        const cityData = {
                            all: [12, 19, 3, 5, 2, 3, 7],
                            Enexis: [12, 19, 3, 5, 2, 3, 7],
                            Liander: [2, 3, 20, 5, 1, 4, 6],
                            Stedin: [3, 10, 13, 15, 22, 30, 8],
                            Enduris: [5, 12, 8, 6, 9, 10, 11],
                            Westlandinfra: [7, 14, 9, 11, 13, 17, 5],
                            Rendo: [4, 8, 6, 9, 12, 15, 10],
                            Coteq: [6, 11, 7, 10, 14, 18, 9]
                            // Add more city data as needed
                        };
                        
                        const ctx = document.getElementById('cityChart').getContext('2d');
                        let cityChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                datasets: [{
                                    label: 'City Data',
                                    data: cityData.all,
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
                                            color: 'white' // Y-axis text color
                                        }
                                    },
                                    x: {
                                        ticks: {
                                            color: 'white' // X-axis text color
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        labels: {
                                            color: 'white' // Legend text color
                                        }
                                    }
                                }
                            }
                        });
                        
                        function filterData() {
                            const selectedCity = document.getElementById('cityFilter').value;
                            cityChart.data.datasets[0].data = cityData[selectedCity];
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