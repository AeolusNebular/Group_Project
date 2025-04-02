<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>
    
    <title>City Council - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- 📍 Navbar -->
    <?php include("../modules/navbar.php");
    require('../Database_Php_Interactions/Database_Utilities.php');
    include('../Database_Php_Interactions/CSVData.php'); ?>
    
    <!-- 🏙️ City page content -->
    <div class="container mt-4">
        
        <!-- 📛 Title -->
        <div class="text-center">
            <h2>City</h2>
        </div>
        
        <!-- 📈 Network graph -->
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="card" >
                    <div class="card-header">📊 Network Graph</div>
                    <div class="card-body">
                        
                        <!-- 🧭 Network selection -->
                        <form action="City.php" method='GET'>
                            <?php if (!$RoleID == 2) {
                                echo '<div class="themed-dropdown" style="float: left">
                                    <label for="CityNetworks">Select network:</label> <br>
                                    <select class="form-select" name="CityNetworks">
                                        <option value="coteq"> Coteq </option>      
                                        <option value="westland-infra"> Westlandia </option>
                                        <option value="enexis"> Enexis </option>
                                        <option value="stedin"> Stedin </option>
                                        <option value="liander"> Liander </option>
                                    </select>
                                </div>';
                            }
                            ?>
                            <div class="themed-dropdown" style='float: right'>
                                <label for="CityYears">Select network:</label> <br>
                                <select class="form-select" name="CityYears" >
                                    <option value="2016"> 2016 </option>      
                                    <option value="2017"> 2017 </option>
                                    <option value="2018"> 2018 </option>
                                    <option value="2019"> 2019 </option>
                                    <option value="2020"> 2020 </option>
                                </select>
                            </div> 

                            <button type="Submit" class="fancy-button" style = 'margin-top : 15px'>
                                Apply Filter
                            </button>
                        </form>
                        
                        <canvas id="CityCanvas"></canvas>
                        
                        <?php 
                            if ($_SERVER['REQUEST_METHOD'] == 'GET') {

                                $Network = isset($_GET['CityNetworks']) ? $_GET['CityNetworks'] : $RoleNetwork;
                                $Years = isset($_GET['CityYears']) ? $_GET['CityYears'] : '2016';
                                $Types = ['Electricity','Gas'];
                                $CityTypeValues = array('Electricity' => [], 'Gas' => []);
                                $CityValues = [];
                                $AllCityDataForType = array('Electricity' => [], 'Gas' => []);
                                

                                foreach ($Types as $Type) {
                                    $CityAdditions = array('Annual' => 0, 'Connection' => 0, 'Delivery_Perc' => 0);
                                    $x = 0;
                                    if (isset($_SESSION['City_Name'])) {
                                        $CityGraphValues = FilterByCityCSV($Type,$Years,$Network,$_SESSION['City_Name']);
                                    } else {
                                        $CityGraphValues = CSVData($Type,$Years,$Network);
                                    }

                                    foreach ($CityGraphValues as $Key => $City) {
                                        $x += 1;                                  
                                        $CityValues[$Key] =  $City[0];
                                        $CityAdditions['Annual'] += $City[0];
                                        $CityAdditions['Connection'] += $City[1];
                                        $CityAdditions['Delivery_Perc'] += $City[2]/100;
                                       
                                    } 
                                    $CityAdditions['Delivery_Perc'] = $CityAdditions['Delivery_Perc']/$x;
                                    $AllCityDataForType[$Type] = $CityAdditions;   
                                    $CityTypeValues[$Type] = $CityValues;
                                    
                                }

                            }        
                        ?>

                        <script> 
                           var data = <?php echo json_encode($CityTypeValues['Electricity']); ?>;
                         
                           document.addEventListener("DOMContentLoaded", function () {
                                drawBarGraph();
                                window.addEventListener("resize", drawBarGraph); // ✅ Attach resize event once
                            });

                        function drawBarGraph() {
                            let font = { family: "Space Grotesk"};
                            let textColor = theme ? "#000" : "#fff";

                            const canvas = document.getElementById("CityCanvas");
                            
                            // ✅ Ensure the canvas context is fresh
                            if (!canvas) return; // 👋 Exit if canvas is missing
                            const ctx = canvas.getContext("2d");
                            
                            // 💥 Destroy existing chart properly
                            if (chartInstance) {
                                chartInstance.destroy();
                                chartInstance = null; // 🧹 Clear instance reference
                            }

                            chartInstance = new Chart(ctx, {
                                type: "bar",
                                data: {
                                    labels: Object.keys(data),
                                    datasets: [{
                                        label: "Electricity",
                                        data: Object.values(data) ,
                                        borderColor: "#975ae100",
                                        backgroundColor: [
                                            '#003f5c',
                                            '#374c80',
                                            '#58508d',
                                            '#7a5195',                    
                                            '#bc5090',
                                            '#ff6361',
                                            '#ffa600'
                                        ],
                                    
                                    }]
                                },
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
            
            <!-- 📅 Annual summary -->
            <div class="col-12 col-md-5">
                <div class="card">
                    <div class="card-header">📅 Annual Summary</div>
                    <div class="card-body">
                        <form action = 'ReportPDF.php' method= 'POST'>
                            <div id="SummaryContent">Number of Connections: <?php echo json_encode(($AllCityDataForType['Electricity']['Connection'] + $AllCityDataForType['Electricity']['Connection'])) ?> </div>
                            <div id="SummaryContent">Electricity Used (kWh) <?php echo json_encode(($AllCityDataForType['Electricity']['Annual'])) ?></div>
                            <div id="SummaryContent">Gas Used (m<sup>3</sup>): <?php echo json_encode(($AllCityDataForType['Gas']['Annual']))?></div>
                            <div id="SummaryContent">Delivery Percentage: <?php echo json_encode(round($AllCityDataForType['Electricity']['Delivery_Perc'] + $AllCityDataForType['Electricity']['Delivery_Perc'])) ?> </div>
                            <div id="SummaryContent">Connections Types: </div>
                            <div id="SummaryContent">Connection Type Percentages: </div>
                            <input type="hidden" id = 'CityValuesForPDF' name = 'CityValuesForPDF' value =" <?php  echo htmlentities(json_encode($CityTypeValues));  ?>">
                            <div id="SummaryContent">
                                <button type="Submit" class="fancy-button" style="float: right">Print Summary</button>
                            </div> 
                        </form>                                          
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