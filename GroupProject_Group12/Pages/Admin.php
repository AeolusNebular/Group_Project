<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>
    
    <title>Admin - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- 📍 Navbar -->
    <?php include("../modules/navbar.php");
    require_once('../Database_Php_Interactions/Database_Utilities.php');
    include('../Database_Php_Interactions/CSVData.php');
    try {
        include("../modules/CreateUser.php");
    } catch (Exception $e) {
        echo "error loading cities";
    } 
    ?>
    
    <!-- 🛡️ Admin page content -->
    <div class="container-lg mt-4">
        
        <!-- 📛 Title -->
        <div class="text-center">
            <h2> Admin </h2>
        </div>
        
        <div class="row gx-1">
            <div class="col-12 col-md-7 d-flex">
                <div class="card h-90">
                    <div class="card-header"> 🌐 Network Users </div>
                    <div class="card-body">
                        
                        <form action="Admin.php" method='GET'>
                            <div class="themed-dropdown" style='float: left'>
                                <label for="Admin_Network_Year"> Select year: </label> <br>
                                <select class="form-select" name="Admin_Network_Year" id="Admin_Network_Year">
                                    <option value="2016"> 2016 </option>
                                    <option value="2017"> 2017 </option>
                                    <option value="2018"> 2018 </option>
                                    <option value="2019"> 2019 </option>
                                    <option value="2020"> 2020 </option>
                                </select>
                            </div>
                            <div class="themed-dropdown" style='float: left'>
                                <label for="Admin_Network_Type"> Select type: </label> <br>
                                <select class="form-select" name="Admin_Network_Type" id="Admin_Network_Type">
                                    <option value="electricity"> Electricity </option>
                                    <option value="gas">         Gas </option>
                                </select>
                            </div>
                            <button type="Submit" class="fancy-button" style='float: right'>
                                Apply Filter
                            </button>
                        </form>
                        
                        <canvas id="NetworkCanvas"></canvas>
                        
                        <?php
                            // ✅ Check if requested method has been run (eg form submit)
                            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                                
                                // 📅 Check if year has been selected, else assigns default (2016)
                                $Year = isset($_GET['Admin_Network_Year']) ? $_GET['Admin_Network_Year'] : '2016';
                                // 🔄 Check if an electricity/gas selection has been made, else assigns default (electricity)
                                $Type = isset($_GET['Admin_Network_Type']) ? $_GET['Admin_Network_Type'] : 'electricity';
                                
                                // 🌐 Assigns network variable required for the CSV to display and use in the javascript graph
                                $Networks = ['coteq' , 'enexis' , 'liander' , 'stedin' , 'westland-infra'];
                                $NetworkConsumeTotals = array('coteq' => 0,'enexis' => 0,'liander' => 0,'stedin' => 0,'westland-infra' => 0);
                                
                                // 🔁 Iterates through the array of networks and grabs the value to be assigned to the NetworkConsumeTotals for graph display
                                foreach ($Networks as $Network) {
                                    // 📂 Runs CSVData with assigned variables and grabs data from said CSV file
                                    $Values = CSVData($Type,$Year,$Network);
                                    
                                    // 🔑 Values = Key(City Name) + Annual Consume(0) + Num of Connections(1)  
                                    foreach ($Values as $Value) {
                                        // 🔄 Assigns annual consume to selected network in loop
                                        $NetworkConsumeTotals[$Network] += $Value[0];
                                    }
                                }
                            
                            }
                        ?>
                        
                        <script>
                            // 📡 Grabs network consume from PHP code above using JSON encode function and assigns to data
                            var data = <?php echo json_encode($NetworkConsumeTotals); ?>;
                            
                            document.addEventListener("DOMContentLoaded", function () {
                                drawDoughnut();
                                window.addEventListener("resize", drawDoughnut); // ✅ Attach resize event once
                            });
                            
                            // 🍩 Create doughnut chart displaying network consumption data
                            function drawDoughnut() {
                                let font = { family: "Space Grotesk"};
                                
                                // 🎨 Retrieve the current mode (light or dark) from sessionStorage for text colour
                                const storedThemeMode = sessionStorage.getItem("themeMode")
                                const [storedTheme, storedMode] = storedThemeMode.split("-");
                                let textColor = storedMode === "light" ? "#000" : "#fff";
                                
                                const canvas = document.getElementById("NetworkCanvas");
                                
                                // ✅ Ensure the canvas context is fresh
                                if (!canvas) return; // 👋 Exit if canvas is missing
                                const ctx = canvas.getContext("2d");
                                
                                // 💥 Destroy existing chart properly
                                if (chartInstance) {
                                    chartInstance.destroy();
                                    chartInstance = null; // 🧹 Clear instance reference
                                }
                                
                                chartInstance = new Chart(ctx, {
                                    type: "doughnut",
                                    data: {
                                        labels: ["Coteq", "Stedin", "Liander", "Westlandinfra", "Enexis"],
                                        datasets: [{
                                            label: "Networks",
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
                            };
                        </script>
                    </div>
                </div>
            </div>
            
            <!-- 📊 Big chart panel (fat) -->
            <div class="col-12 col-md-5 d-flex">
                <div class="card h-90">
                    <div class="card-header"> 👤 User Creation </div>
                    <div class="card-body">
                        <button type="button" class="fancy-button" data-bs-toggle="modal" data-bs-target="#CreateModal" aria-label="Create a new user">
                            Create User
                        </button>
                        
                        <!--
                        // Email test button
                        <form action="../Database_Php_Interactions/EmailSender.php" method = 'POST'>
                            <input type="text" id= 'Email' name='Email'>
                            <button type="submit" class="fancy-button">Send Email</button>
                        </form>
                        -->
                    </div>
                </div>
            </div>
            
            <!-- 🏙️ City councils diagram -->
            <div class="col-12 col-md-12 d-flex">
                <div class="card h-90">
                    <div class="card-header"> 🏙️ City Council Diagram </div>
                    <div class="card-body">
                        
                        <!-- 🏙️ City filter -->
                        <form action="Admin.php" method="GET">
                            <div class="themed-dropdown" style="float: left">
                                <label for="AdminNetwork"> Select network: </label><br>
                                <select class="form-select" name="AdminNetwork">
                                    <option value="coteq">          Coteq </option>
                                    <option value="westland-infra"> Westlandia </option>
                                    <option value="enexis">         Enexis </option>
                                    <option value="stedin">         Stedin </option>
                                    <option value="liander">        Liander </option>
                                </select>
                            </div>
                            <div class="themed-dropdown" style="float: left">
                                <label for="AdminNetworkYear"> Select year: </label><br>
                                <select class="form-select" name="AdminNetworkYear">
                                    <option value="2016"> 2016 </option>
                                    <option value="2017"> 2017 </option>
                                    <option value="2018"> 2018 </option>
                                    <option value="2019"> 2019 </option>
                                    <option value="2020"> 2020 </option>
                                </select>
                            </div>
                            <div class="themed-dropdown" style="float: left">
                                <label for="Admin_City_Type"> Select type: </label><br>
                                <select class="form-select" name="Admin_City_Type">
                                    <option value="electricity"> Electricity </option>
                                    <option value="gas">         Gas </option>
                                </select>
                            </div>
                            <button type="Submit" class="fancy-button" style="float: right">
                                Apply Filter
                            </button>
                        </form>
                        
                        <!-- 📊 City councils chart -->
                        <canvas id="AdminCityCouncilCanvas"></canvas>
                        
                        <?php
                            $CityYear = isset($_GET['AdminNetworkYear']) ? $_GET['AdminNetworkYear'] : '2016';
                            $CityType = isset($_GET['Admin_City_Type']) ? $_GET['Admin_City_Type'] : 'electricity';
                            $CityNetwork = isset($_GET['AdminNetwork']) ? $_GET['AdminNetwork'] : 'coteq';
                            $CityValues = [];
                            
                            $CityGraphValues = CSVData($CityType,$CityYear,$CityNetwork);
                            
                            foreach ($CityGraphValues as $Key => $City) {
                                $CityValues[$Key] =  $City[0];
                            }
                            debug_to_console($CityValues);
                        ?>
                        
                        <script>
                           var citydata = <?php echo json_encode($CityValues); ?>;
                           console.log(Object.values(data));
                           document.addEventListener("DOMContentLoaded", function () {
                                drawBarGraph();
                                window.addEventListener("resize", drawBarGraph); // ✅ Attach resize event once
                            });
                            
                            function drawBarGraph() {
                                let font = { family: "Space Grotesk"};
                                
                                // 🎨 Retrieve the current mode (light or dark) from sessionStorage for text colour
                                const storedThemeMode = sessionStorage.getItem("themeMode")
                                const [storedTheme, storedMode] = storedThemeMode.split("-");
                                let textColor = storedMode === "light" ? "#000" : "#fff";
                                
                                const citycanvas = document.getElementById("AdminCityCouncilCanvas");
                                
                                // ✅ Ensure the canvas context is fresh
                                if (!citycanvas) return; // Exit if canvas is missing
                                const ctx = citycanvas.getContext("2d");
                                
                                /*
                                // 💥 Destroy existing chart properly
                                if (chartInstance) {
                                    chartInstance.destroy();
                                    chartInstance = null; // 🧹 Clear instance reference
                                }
                                */
                                
                                chartInstance = new Chart(ctx, {
                                    type: "bar",
                                    data: {
                                        labels: Object.keys(citydata),
                                        datasets: [{
                                            label: <?php echo json_encode($Type)?>,
                                            data: Object.values(citydata),
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
            
            <div class="col-12 col-md-7 d-flex">
                <div class="card h-90">
                    <div class="card-header"> Additional Information </div>
                    <div class="card-body">
                        <div id="SummaryContent"> Number of connections: </div>
                        <div id="SummaryContent"> Amount of electricity used (kWh): </div>
                        <div id="SummaryContent"> Amount of gas used (m<sup>3</sup>): </div>
                        <div id="SummaryContent"> Delivery percentage: </div>
                        <div id="SummaryContent"> Connection types: </div>
                        <div id="SummaryContent"> Connection types percentage: </div>
                        <div id="SummaryContent"> <br> </div>
                    </div>
                </div> 
            </div>
            
            <div class="col-12 col-md-5 d-flex">
                <div class="card h-90">
                    <div class="card-header"> Filter options: </div>
                    <div class="card-body">
                        
                        <div id="SummaryContent" class="themed-dropdown"> Filter report by city: 
                            <select class="form-select" id="ReportAdminFilter">
                                <option value="all"> All </option>
                                <?php
                                    include('../Database_Php_Interactions/CitySelect.php');
                                ?>
                            </select>
                        </div>
                        
                        <div id="SummaryContent" class="themed-dropdown"> Filter report by utility: 
                            <select class="form-select" id="Gas_Electricity_Both">
                                <option value="Both">        All</option>
                                <option value="Gas">         Gas</option>
                                <option value="Electricity"> Electricity</option>
                            </select>
                        </div>
                        
                        <div id="SummaryContent">
                            <button type="button" class="fancy-button" style="float: right"> Print Summary </button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <!-- 👣 Footer -->
    <?php include("../modules/footer.php"); ?>

</body>
</html>