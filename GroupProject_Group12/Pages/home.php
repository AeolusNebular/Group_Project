<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>
    <title>Home - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- 📍 Navbar -->
    <?php 
    include("../modules/navbar.php");
    require_once('../Database_Php_Interactions/Database_Utilities.php');
    include('../Database_Php_Interactions/CSVData.php');
    include("../modules/login.php");
    ?>

    
    <!-- 🏠 Home page content (dashboard) -->
    <div class="container mt-4">
        
        <!-- 📛 Title -->
        <div class="text-center">
            <h2> Dashboard </h2>
        </div>
        
        <div class="row gx-1">
            <!-- 📈 Big chart panel (fat) -->
            <div class="col-12 col-md-8 d-flex">
                <div class="card h-90">
                    <div class="card-header"> 📊 Energy Usage Overview </div>
                    <div class="card-body">
                        <form action="home.php" method="GET">
                            <div class="themed-dropdown" style="float: left">
                                <label for="Dashboard_Years"> Select year: </label> <br>
                                <select class="form-select" name="Dashboard_Years">
                                    <option value="2016"> 2016 </option>
                                    <option value="2017"> 2017 </option>
                                    <option value="2018"> 2018 </option>
                                    <option value="2019"> 2019 </option>
                                    <option value="2020"> 2020 </option>
                                </select>
                            </div>
                            <?php
                                if ($RoleID != 2) {
                                echo '<div class="themed-dropdown" style="float: left">
                                    <label for="Dashboard_Networks"> Select network: </label><br>
                                    <select class="form-select" name="Dashboard_Networks">
                                        <option value="coteq">          Coteq </option>
                                        <option value="westland-infra"> Westlandia </option>
                                        <option value="enexis">         Enexis </option>
                                        <option value="stedin">         Stedin </option>
                                        <option value="liander">        Liander </option>
                                    </select>
                                </div>';
                                }
                            ?>
                            <button type="Submit" class="fancy-button" style="margin-top: 15px; float: right;">
                                Apply Filter
                            </button>
                        </form>

                        <canvas id="DashboardCanvas"></canvas>
                        
                        <?php
                            if (isset($RoleID)) {
                                // 📅 Runs once year is chosen, defaults to 2020
                                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                                    $Year = isset($_GET['Dashboard_Years']) ? $_GET['Dashboard_Years'] : '2016';
                                    $TypesOfCSV = ['Gas','Electricity'];
                                    $DashboardNetwork = isset($_GET['Dashboard_Networks']) ? $_GET['Dashboard_Networks'] : 'coteq';
                                    $AllCSVCityData = array('Gas' => [],'Electricity' => []);
                                    
                                    // 🔄 Loops through types of CSV (eg electricity or gas)
                                    foreach ($TypesOfCSV as $TypeOfCSV) {
                                        // 👤 Checks user's RoleID to decide which information to show 
                                        if ($RoleID != '3' ) {
                                            $CityConsumeTotals = [];
                                            if ($RoleID == 2) {
                                                $RoleNetworkCSVValues = CSVData($TypeOfCSV,$Year,$RoleNetwork);
                                            } else {
                                                $RoleNetworkCSVValues = CSVData($TypeOfCSV,$Year,$DashboardNetwork);
                                            }
                                            
                                            foreach ($RoleNetworkCSVValues as $CityName => $City) {
                                                if (!isset($CityConsumeTotals[$CityName])) {
                                                    $CityConsumeTotals[$CityName] = 0;
                                                }
                                                
                                                $CityConsumeTotals[$CityName] += $City[0];
                                            }
                                            
                                            $AllCSVCityData[$TypeOfCSV] += $CityConsumeTotals;
                                            
                                        } elseif ($RoleID == '3' && isset($CityFilter)) {
                                            
                                            $RoleNetworks = ['coteq','enexis','liander','stedin','westland-infra'];
                                            
                                            $NetworkConsumeTotals = array('coteq' => 0,'enexis' => 0,'liander' => 0,'stedin' => 0,'westland-infra' => 0);
                                            foreach ($RoleNetworks as $Network) {
                                                // 📂 Runs CSVData with assigned variables and grabs data from said CSV File
                                                $Values = FilterByCityCSV($TypeOfCSV,$Year,$Network,$CityFilter);
                                                
                                                foreach ($Values as $CityName => $CityData) {
                                                    
                                                    // 🔢 Assigns annual consume to the selected network in loop
                                                    $NetworkConsumeTotals[$Network] += $CityData['11'];
                                                }
                                            }
                                            $AllCSVCityData[$TypeOfCSV] += $NetworkConsumeTotals;
                                        }
                                    }
                                    // 🔍 Debug output for each Network's values
                                    foreach ($AllCSVCityData as $KEY => $NetworkValues) {
                                    
                                    }
                                }
                            }
                        ?>
                        
                        <script>
                            // 📝 Grabs network consume from PHP code above using JSON Encode function and assigns it to data
                            var pieChart, URI;
                            var DashboardData = <?php echo json_encode($AllCSVCityData); ?>;
                            console.log(DashboardData);
                            
                            document.addEventListener("DOMContentLoaded", function () {
                                drawMixedGraph();
                                window.addEventListener("resize", drawMixedGraph); // 🖼️ Attach resize event once
                            });
                            
                            function drawMixedGraph() {
                                let font = { family: "Space Grotesk"};
                                
                                // 🎨 Retrieve the current mode (light or dark) from sessionStorage for text colour
                                const storedThemeMode = sessionStorage.getItem("themeMode")
                                const [storedTheme, storedMode] = storedThemeMode.split("-");
                                let textColor = storedMode === "light" ? "#000" : "#fff";
                                
                                const canvas = document.getElementById("DashboardCanvas");
                                
                                // ✅ Ensure canvas context is fresh
                                if (!canvas) return; // 👋 Exit if canvas is missing
                                const ctx = canvas.getContext("2d");
                                
                                // 💥 Destroy existing chart properly
                                if (chartInstance) {
                                    chartInstance.destroy();
                                    chartInstance = null; // 🧹 Clear instance reference
                                }
                                const data = {
                                    labels: Object.keys(DashboardData['Electricity']),
                                    datasets: [{
                                        type: 'pie', // 🍩 Doughnut chart for gas
                                        label: 'Gas',
                                        data: Object.values(DashboardData['Gas']),
                                        // 🟠 Solid colours for Gas
                                        borderColor: '#00000000',
                                        backgroundColor: [
                                            '#003f5c', '#374c80', '#58508d', '#7a5195', '#bc5090', 
                                            '#ff6361', '#ffa600'
                                        ],
                                        zIndex: 1
                                    }, {
                                        type: 'bar',  // Line chart for electricity
                                        label: 'Electricity',
                                        data: Object.values(DashboardData['Electricity']),
                                        fill: false,
                                        backgroundColor: [
                                            '#003f5c', '#374c80', '#58508d', '#7a5195', '#bc5090', 
                                            '#ff6361', '#ffa600'
                                        ],
                                        zIndex: 2
                                    }]
                                };
                                
                                chartInstance = new Chart(ctx, {
                                    type: "scatter",
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
            <div class="col-12 col-md-4 d-flex">
                <div class="card h-90">
                    <div class="card-header"> ⚡ Latest Energy Stats </div>
                    <div class="card-body">
                        <p> <b>Usage:</b> 1,250 kWh </p>
                        <p> <b>Efficiency:</b> 85% </p>
                        <p> <b>Cost:</b> £120 </p>
                    </div>
                </div>
            </div>
            
            <!-- Two even cards -->
            <div class="col-12 col-md-6 d-flex">
                <div class="card h-90">
                    <div class="card-header"> 🔍 Analysis </div>
                    <div class="card-body">
                        <p> Last month saw a <b>15% decrease</b> in energy consumption. </p>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6 d-flex">
                <div class="card h-90">
                    <div class="card-header">⚙️ Recommendations</div>
                    <div class="card-body">
                        <ul>
                            <li>Switch to <b>LED lighting</b>.</li>
                            <li>Optimise heating settings.</li>
                            <li>Use smart plugs.</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Full-width bottom card -->
            <div class="col-12 d-flex">
                <div class="card h-90">
                    <div class="card-header">⚠️ Warning</div>
                    <div class="card-body">
                        Your energy consumption is <b>15% above</b> the expected range this month. Holy guacamole!!
                    </div>
                </div>
            </div>
            
            <!-- 🗺️ Heatmap -->
            <div class="col-12 col-md-12 d-flex">
                <div class="card h-90">
                    <div class="card-header">🗺️ Energy Use Heatmap</div>
                    <div id="heatmap"></div> <!-- 🗺️ Heatmap container -->
                </div>
            </div>
            
        </div>
    </div>
    
    <!-- 👣 Footer -->
    <?php include("../modules/footer.php"); ?>
    
</body>
</html>