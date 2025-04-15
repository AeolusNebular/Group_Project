<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>
    
    <title> Admin - Smart Energy Dashboard </title>
</head>

<body>
    
    <!-- 📍 Navbar and login -->
    <?php 
        include("../modules/navbar.php");
        include("../modules/login.php");
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
                                    <option value="Electricity"> Electricity </option>
                                    <option value="Gas">         Gas </option>
                                </select>
                            </div>
                            <button type="Submit" class="fancy-button" style='float: right'>
                                Apply Filter
                            </button>
                        </form>
                        
                        <!-- 📨 Fetch graph scripts -->
                        <?php include("../scripts/graph.php"); ?>
                        
                        <!-- ✏️ Draw desired graph -->
                        <canvas id="networkCanvas"></canvas>
                        
                    </div>
                </div>
            </div>
            
            <!-- 📊 Big chart panel (fat) -->
            <div class="col-12 col-md-5 d-flex">
                <div class="card h-90">
                    <div class="card-header"> 👤 Additional Admin Options </div>
                    <div class="card-body">
                        
                        <!-- 👤 User creation modal -->
                        <div class="col-md-10">
                            <p> Create new dashboard user. </p>
                        </div>
                        <button type="button" class="fancy-button" data-bs-toggle="modal" data-bs-target="#CreateModal" aria-label="Create a new user">
                            Create User
                        </button>
                        
                        <br>
                        <br>
                        
                        <!-- 🔔 Notification popup test button -->
                        <div class="col-md-10">
                            <h3> Debugging Options </h3>
                            <p> Trigger test notification popup. </p>
                        </div>
                        <button class="notifpopup fancy-button" onclick="createNotificationPopup('', 'Energy Spike Alert', 'A new energy usage spike has been detected! Panic!');">
                            Notification Popup
                        </button>
                        
                        <!-- 🔔 Notification creation modal will go here -->
                         
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
                                    <option value="Electricity"> Electricity </option>
                                    <option value="Gas">         Gas </option>
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
                            $CityType = isset($_GET['Admin_City_Type']) ? $_GET['Admin_City_Type'] : 'Electricity'; 
                            $CityNetwork = isset($_GET['AdminNetwork']) ? $_GET['AdminNetwork'] : 'coteq';
                            $Types = ['Gas', 'Electricity'];

                            $AllAdminCityAnnualTypes = ['Gas' => [], 'Electricity' => []];
                            $AllAdminCityValueTypes = ['Gas' => [], 'Electricity' => []];
                            foreach ($Types as $Type) {
                                $CityValues = [];
                                $AllCityValuesAdmin =  ['Annual' => 0, 'Connection' => 0, 'Delivery_Perc' => 0];  
                                $CityGraphValues = CSVData($CityType,$CityYear,$CityNetwork);
                                
                                foreach ($CityGraphValues as $Key => $City) {
                                    $CityValues[$Key] =  $City[0];
                                    $AllCityValuesAdmin['Annual'] += $City[0];
                                    $AllCityValuesAdmin['Connection'] += $City[1];
                                    $AllCityValuesAdmin['Delivery_Perc'] += $City[2];

                                }
                                $AllAdminCityAnnualTypes[$Type] = $CityValues;
                                $AllAdminCityValueTypes[$Type] = $AllCityValuesAdmin;
                            }
                        ?>
                        
                        <script>
                            var citydata = <?php echo json_encode($AllAdminCityAnnualTypes[$CityType]); ?>;
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
                                
                                // 🧠 Use computed styles to fetch CSS variable values
                                const root = document.body;
                                let textColor = storedMode === "light"
                                    ? getComputedStyle(root).getPropertyValue("--text-light").trim()
                                    : getComputedStyle(root).getPropertyValue("--text-dark").trim();
                                
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
                                            label: <?php echo json_encode(ucfirst($Type))?>,
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
                                        animation: {
                                            duration: 700,
                                            easing: 'easeOutQuad',
                                            onComplete: function () {
                                                URI = chartInstance.toBase64Image("image/jpeg", 1);
                                                const imageField = document.getElementById('ImageURLForPDF');
                                                if (imageField) imageField.value = URI;
                                                console.log(URI);
                                            }
                                        },
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
                    <div class="card-header"> Additional Information: <?php echo (isset($_GET['AdminAdditionalInfo']) && $_GET['AdminAdditionalInfo'] == 'Network') ? $_GET['AdminAdditionalInfo'] : 'City'?> </div>
                    <div class="card-body">   
                    <form action = 'Admin.php' Method = 'GET'>
                        <div id="SummaryContent"> Number of connections:  <?php echo (isset($_GET['AdminAdditionalInfo']) && $_GET['AdminAdditionalInfo'] == 'Network') ? json_encode(round($AllAdminNetworkValueByType['Electricity']['Connection']+$AllAdminNetworkValueByType['Gas']['Connection'])) : json_encode(round($AllAdminCityValueTypes['Electricity']['Connection'] + $AllAdminCityValueTypes['Gas']['Connection']));?></div>
                        <div id="SummaryContent"> Amount of electricity used (kWh): <?php echo (isset($_GET['AdminAdditionalInfo']) && $_GET['AdminAdditionalInfo'] == 'Network') ? json_encode($AllAdminNetworkValueByType['Electricity']['Annual']) : json_encode($AllAdminCityValueTypes['Electricity']['Annual']);?> </div>
                        <div id="SummaryContent"> Amount of gas used (m<sup>3</sup>): <?php echo (isset($_GET['AdminAdditionalInfo']) && $_GET['AdminAdditionalInfo'] == 'Network') ? json_encode($AllAdminNetworkValueByType['Gas']['Annual']) : json_encode($AllAdminCityValueTypes['Gas']['Annual']);?>  </div>
                        <div id="SummaryContent"> Delivery percentage: <?php echo (isset($_GET['AdminAdditionalInfo']) && $_GET['AdminAdditionalInfo'] == 'Network') ? json_encode(round($AllAdminNetworkValueByType['Electricity']['Delivery_Perc'] + $AllAdminNetworkValueByType['Gas']['Delivery_Perc'])) : json_encode(round($AllAdminCityValueTypes['Electricity']['Delivery_Perc'] + $AllAdminCityValueTypes['Gas']['Delivery_Perc']));?>  </div>
                        <div id="SummaryContent"> <br> </div>
                        <div class="themed-dropdown" style='float: left'>
                            <label for="AdminAdditionalInfo"> Additional Info type: </label> <br>
                            <select class="form-select" id='AdminAdditionalInfo' name="AdminAdditionalInfo">
                                <option value="Network"> Network </option>
                                <option value="City"> City </option>
                            </select>
                        </div>
                        <div id="SummaryContent">
                            <button type="Submit" class="fancy-button" style="float: right"> Change Summary </button>
                        </div>
                    </form>
                    </div>
                </div> 
            </div>
            
            <div class="col-12 col-md-5 d-flex">
                <div class="card h-90">
                    <div class="card-header"> Filter options: </div>
                    <div class="card-body">
                        <form id = 'AdminReportForm' method = 'POST'>
                        
                            <div class="themed-dropdown" style='float: left'>
                                <label for="AdminReportType"> Report type: </label> <br>
                                <select class="form-select" id='AdminReportType' name="AdminReportType">
                                    <option value="PDF"> PDF </option>
                                    <option value="CSV"> CSV </option>
                                </select>
                            </div>
                            <div id="SummaryContent"> <br> </div>
                            <input type="hidden" id='AdminValuesForPDF' name='ValuesForPDF' value="<?php echo htmlentities(json_encode($AllAdminCityAnnualTypes))  ; ?>">
                            <input type="hidden" id='AdminValuesForCSV' name='AdminValuesForCSV' value="<?php echo htmlentities(json_encode($AllAdminCityAnnualTypes)); ?>">
                            <input type="hidden" id='ImageURLForPDF' name='ImageURLForPDF'>

                            <div id="SummaryContent"> <br> </div>                        
                            <div id="SummaryContent">
                                <button type="button" onClick = 'submitAdminReports()' class="fancy-button" style="float: right"> Print Summary </button>
                            </div>
                        </form>
                    </div>
                    
                    <script>
                        function submitAdminReports() {
                            if (document.getElementById('AdminReportType').value == 'PDF') {
                                document.getElementById("AdminReportForm").action = '../modules/reportPDF.php';
                                document.getElementById("AdminReportForm").submit();

                            } else {
                                document.getElementById("AdminReportForm").action = 'Admin.php';
                                document.getElementById("AdminReportForm").submit();
                            }
                        }
                    </script>

                    <?php 
                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['AdminReportType']) && $_POST['AdminReportType'] == 'CSV')) {
                            $Headings =  ($_POST['AdminReportInfo'] == 'City') ? ['City','Gas','Electricity'] : ['Network','Gas','Electricity'];    
                            $JsonData = html_entity_decode($_POST['AdminValuesForCSV']);
                            $AdminValues = json_decode($JsonData);

                            $AdminCityValuesInArray = [];
                            foreach ($AdminValues as $ConsumeType => $NetworkConsumes){
                                // ['City','Electricity','Gas']
                                foreach ($NetworkConsumes as $City => $NetworkConsumeValue) {
                                    if (!isset($AdminCityValuesinArray[$City])) {
                                        $AdminCityValuesinArray[$City] = [];
                                    }
                                    // EG [GOOR][ELECTRICITY,GAS][241241,321454]
                                    $AdminCityValuesinArray[$City][$ConsumeType] = $NetworkConsumeValue;
                                }
                            }
                            $fp = fopen('../Reports/AdminReport.csv', 'w');
                            fputcsv($fp,$Headings);
                            foreach ($AdminCityValuesinArray as $City => $ConsumeValues){
                                $CSVRowData = [$City];
                                foreach ($ConsumeValues as $ConsumeType => $AnnualConsume) {
                                    array_push($CSVRowData,$AnnualConsume);
                                }
                                fputcsv($fp,$CSVRowData);
                            }
                            fclose($fp);

                            echo
                                '<iframe id="my_iframe" style="display:none;"></iframe>
                                    <script>
                                        document.getElementById("my_iframe").src = "../Reports/AdminReport.csv";
                                    </script>
                                '
                            ;
                            
                        }
                    ?>
                </div>
            </div>
            
        </div>
    </div>
    
    <!-- 👣 Footer -->
    <?php include("../modules/footer.php"); ?>

</body>
</html>