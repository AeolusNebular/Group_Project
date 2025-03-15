<!DOCTYPE html>
<html lang="en-gb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/Group_Project/GroupProject_Group12/images/favicon.png">
    
    <title>Network - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- 📍 Navbar -->
    <?php include("../modules/navbar.php"); ?>
    
    <!-- Network page content -->
    <div class="container mt-4">

        <!-- 📛 Title -->
        <div class="text-center">
            <h2>Network:</h2>
        </div>
        <div class ="row">
            <div style="text-align: center; margin-bottom: 20px;">
                <label for="cityFilter" style="color: white;">Filter by City:</label>
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
            <div class="card" style="height: 90%">
                <div class="card-header" style = "text-align: center">City Chart for Network:</div>
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
                                            color: 'white' // Set y-axis text color to white
                                        }
                                    },
                                    x: {
                                        ticks: {
                                            color: 'white' // Set x-axis text color to white
                                        }
                                    }
                                },
                                plugins: {
                                    legend: {
                                        labels: {
                                            color: 'white' // Set legend text color to white
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
                        
                        <div id = "SummaryContent">Filter report by city: 
                            <select id = "ReportCityFilterNetwork"> 
                                <option value="all">All</option>
                                <option value="City 1">City 1</option>
                                <option value="City 2">City 2</option>
                                <option value="City 3">City 3</option>
                                <option value="City 4">City 4</option>
                                <option value="City 5">City 5</option>
                                <option value="City 6">City 6</option>
                                <option value="City 7">City 7</option>
                            </select>
                        </div>
                        
                        <div id = "SummaryContent">Filter report by utility: 
                            <select id = "Gas_Electricity_Both"> 
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
                    <div id="heatmap" style="height: 500px;"></div> <!-- 🗺️ Heatmap container -->
                </div>
            </div>

        </div>
    </div>
    
</body>
</html>