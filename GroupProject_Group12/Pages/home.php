<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php");
        session_start();
        if (!isset($_SESSION['UserID'])) {
            echo 'Please Login to view this page';    
        } else {
            $RoleID = $_SESSION['RoleID'];
            $UserID = $_SESSION['UserID'];
            if ($RoleID == '2') {
                $RoleNetwork = $_SESSION['Network_Name'];
            } else {
              $CityFilter = $_SESSION['City_Name'];  
            }
            
            
        }
    ?>
    
    <title>Home - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- 📍 Navbar -->
    <?php include("../modules/navbar.php");
    require('../Database_Php_Interactions/Database_Utilities.php');
    include('../Database_Php_Interactions/CSVData.php'); ?>
    
    <!-- 🏠 Home page content (dashboard) -->
    <div class="container mt-4">

        <!-- 📛 Title -->
        <div class="text-center">
            <h2>Dashboard</h2>
        </div>
        
        <div class="row">
            <!-- 📈 Big chart panel (fat) -->
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">📊 Energy Usage Overview</div>
                    <div class="card-body" style="height:500px;">
                        <form action="home.php" method = 'GET'>
                            <div class="themed-dropdown" style = 'float: left'> 
                                <label for="Dashboard_Years">Select Year:</label> <br>
                                <select class = "form-select" Onchange = "this.form.submit()" name="Dashboard_Years" >
                                    <option value="2016"> 2016 </option>
                                    <option value="2017"> 2017 </option>
                                    <option value="2018"> 2018 </option>
                                    <option value="2019"> 2019 </option>
                                    <option value="2020"> 2020 </option>
                                </select>
                            </div>
                        </form>
                        <canvas id="DashboardCanvas"></canvas>

                        <?php 
                            debug_to_console('Role ID IS ' . $RoleID);
                            
                            // Runs Once Year is chosen but also defaults to year 2020 if not given
                            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                                $Year = isset($_GET['Dashboard_Years']) ? $_GET['Dashboard_Years'] : '2020';
                                $TypesOfCSV = ['Gas','Electricity'];
                                $AllCSVCityData = array('Gas' => [],'Electricity' => []);

                                // Loops through types of CSV eg Electricity or Gas
                                foreach ($TypesOfCSV as $TypeOfCSV) {
                                    //Checks users RoleID to decide which Information to show 
                                    if ($RoleID == '2') {
                                        $CityConsumeTotals = [];     
                                        $RoleNetworkCSVValues = CSVData($TypeOfCSV,$Year,$RoleNetwork);
                                        debug_to_console($RoleNetwork);
                                        foreach ($RoleNetworkCSVValues as $CityName => $City) {
                                            if (!isset($CityConsumeTotals[$CityName])) {
                                                $CityConsumeTotals[$CityName] = 0;
                                            }
                                            
                                            $CityConsumeTotals[$CityName] += $City[0];
                                            debug_to_console($CityName);
                                        }
                                        
                                        $AllCSVCityData[$TypeOfCSV] += $CityConsumeTotals;  
                                    
                                    } elseif ($RoleID == '3' && isset($CityFilter)) {

                                        $RoleNetworks = ['coteq' ,'enexis' ,  'liander' , 'stedin' , 'westland-infra'];                              
                                        debug_to_console($CityFilter);
                                        $NetworkConsumeTotals = array('coteq' => 0,'enexis' => 0,'liander' => 0,'stedin' => 0,'westland-infra' => 0);
                                        foreach ($RoleNetworks as $Network) {
                                            // Runs CSVData with assigned variables and grabs data from said CSV File
                                            $Values = FilterByCityCSV($TypeOfCSV,$Year,$Network,$CityFilter);
                           
                                            foreach ($Values as $CityName => $CityData) {
                                                
                                                //Assigns Annual Consume to the Selected Network in Loop
                                                $NetworkConsumeTotals[$Network] += $CityData['11'];
                                                
                                            }                                                                                       
                                        }                                                                                   
                                        $AllCSVCityData[$TypeOfCSV] += $NetworkConsumeTotals;                                        
                                    }                                      
                                } 
                                foreach ($AllCSVCityData as $KEY => $NetworkValues) {
                                    debug_to_console($NetworkValues); 
                                }
                            }
                            
                        ?>


                       
                        <script> 
                            // Grabs the Network consume from Php code above using JSON Encode function and assigns it to data
                            var DashboardData = <?php echo json_encode($AllCSVCityData); ?>; 
                            console.log(DashboardData);
                            document.addEventListener("DOMContentLoaded", function () {
                                drawMixedGraph();
                                window.addEventListener("resize", drawMixedGraph); // ✅ Attach resize event once
                            });

                        function drawMixedGraph() {
                            let font = { family: "Space Grotesk"};
                            let textColor = theme ? "#000" : "#fff";

                            const canvas = document.getElementById("DashboardCanvas");
                            
                            // ✅ Ensure the canvas context is fresh
                            if (!canvas) return; // Exit if canvas is missing
                            const ctx = canvas.getContext("2d");

                            // ✅ Destroy existing chart properly
                            if (chartInstance) {
                                chartInstance.destroy();
                                chartInstance = null; // Clear instance reference
                            }

                            const data = {
                                labels: 
                                    Object.keys(DashboardData['Electricity'])
                                ,
                                datasets: [{
                                    type: 'pie',
                                    label: 'Gas',
                                    data: Object.values(DashboardData['Gas']),
                                    borderColor: 'rgb(255, 99, 132)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)'
                                }, {
                                    type: 'line',
                                    label: 'Electricity',
                                    data: Object.values(DashboardData['Electricity']),
                                    fill: false,
                                    borderColor: 'rgb(54, 162, 235)',
                                    backgroundColor: 'rgba(255, 99, 132)'
                                }]
                            };

                            chartInstance = new Chart(ctx, {
                                type: "Scatter",
                                data: data, 
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: true,
                                    plugins: {
                                        legend: {
                                            position: "bottom",
                                            labels: { color: textColor, font: font }
                                        },
                                        title: {
                                            display: true,
                                            text: "Networks Annual Usage",
                                            color: textColor, 
                                            font: font 
                                        }
                                    },
                                
                                }
                            });
                        }
                        </script>


                    </div>
                </div>
            </div>
            
            <!-- Side panel (thin) -->
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header">⚡ Latest Energy Stats</div>
                    <div class="card-body" style="height:350px;">
                        <p><strong>Usage:</strong> 1,250 kWh</p>
                        <p><strong>Efficiency:</strong> 85%</p>
                        <p><strong>Cost:</strong> £120</p>
                    </div>
                </div>
            </div>
            
            <!-- Two even cards -->
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">🔍 Analysis</div>
                    <div class="card-body">
                        <p>Last month saw a <strong>15% decrease</strong> in energy consumption.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">⚙️ Recommendations</div>
                    <div class="card-body">
                        <ul>
                            <li>Switch to <strong>LED lighting</strong>.</li>
                            <li>Optimise heating settings.</li>
                            <li>Use smart plugs.</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Full-width bottom card -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">⚠️ Warning</div>
                    <div class="card-body">
                        Your energy consumption is <strong>15% above</strong> the expected range this month. Holy guacamole!!
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
            <?php debug_to_console('Login ID is ' . $_SESSION['UserID']); ?>
        </div>
    </div>
    
</body>
</html>