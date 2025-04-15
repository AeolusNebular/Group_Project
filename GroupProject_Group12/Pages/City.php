<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>
    
    <title> City Council - Smart Energy Dashboard </title>
</head>

<body>
    
    <!-- 📍 Navbar and login -->
    <?php 
        include("../modules/navbar.php");
        include("../modules/login.php");
        require_once('../Database_Php_Interactions/Database_Utilities.php');
        include('../Database_Php_Interactions/CSVData.php');
    ?>
    
    <!-- 🏙️ City page content -->
    <div class="container mt-4">
        
        <!-- 📛 Title -->
        <div class="text-center">
            <h2> City 
                <?php 
                    if ($RoleID == 2) {
                        echo ' - ' . $RoleNetwork;
                    } elseif($RoleID == 1) {
                        echo ' - Admin';
                    } else {
                        echo $CityFilter;
                    }
                ?>
            </h2>
        </div>
        
        <!-- 📈 Network graph -->
        <div class="row gx-1">
            <div class="col-12 col-md-7 d-flex">
                <div class="card h-90">
                    <div class="card-header"> 📊 Network Graph </div>
                    <div class="card-body">
                        
                        <!-- 🧭 Network selection -->
                        <form action="City.php" method='GET'>
                            <?php
                                if ($RoleID != 2) {
                                    echo "<div class='themed-dropdown' style='float: left'>
                                        <label for='CityNetworks'> Select network: </label><br>
                                        <select class='form-select' name='CityNetworks'>
                                            <option value='coteq'>          Coteq </option>
                                            <option value='westland-infra'> Westlandia </option>
                                            <option value='enexis'>         Enexis </option>
                                            <option value='stedin'>         Stedin </option>
                                            <option value='liander'>        Liander </option>
                                        </select>
                                    </div>";
                                }
                            ?>
                            <div class="themed-dropdown" style='float: left'>
                                <label for="CityYears"> Select network: </label><br>
                                <select class="form-select" name="CityYears">
                                    <option value="2016"> 2016 </option>
                                    <option value="2017"> 2017 </option>
                                    <option value="2018"> 2018 </option>
                                    <option value="2019"> 2019 </option>
                                    <option value="2020"> 2020 </option>
                                </select>
                            </div>
                            <button type="Submit" class="fancy-button" style='margin-top: 15px; float: right'>
                                Apply Filter
                            </button>
                        </form>
                        
                        <!-- 📨 Fetch graph scripts -->
                        <?php include("../scripts/graph.php"); ?>
                        
                        <!-- ✏️ Draw desired graph -->
                        <canvas id="cityCanvas"></canvas>
                        
                    </div>
                </div>
            </div>
            
            <!-- 📅 Annual summary -->
            <div class="col-12 col-md-5 d-flex">
                <div class="card h-90">
                    <div class="card-header"> 📅 Annual Summary </div>
                    <div class="card-body">
                        <form id='CityReportForm' method='POST'>
                            <div id="SummaryContent"> Number of connections: <?php echo json_encode(round($AllCityDataForType['Electricity']['Connection'] + $AllCityDataForType['Electricity']['Connection'])) ?> </div>
                            <div id="SummaryContent"> Electricity used (kWh): <?php echo json_encode(($AllCityDataForType['Electricity']['Annual'])) ?> </div>
                            <div id="SummaryContent"> Gas used (m<sup>3</sup>): <?php echo json_encode(($AllCityDataForType['Gas']['Annual']))?> </div>
                            <div id="SummaryContent"> Delivery percentage: <?php echo json_encode(round($AllCityDataForType['Electricity']['Delivery_Perc'] + $AllCityDataForType['Electricity']['Delivery_Perc'])) ?> </div>
                            <div id="SummaryContent"> <br> </div>
                            <div class="themed-dropdown" style='float: left'>
                                <label for="CityReportType"> Report type: </label> <br>
                                <select class="form-select" id='CityReportType' name="CityReportType">
                                    <option value="PDF"> PDF </option>
                                    <option value="CSV"> CSV </option>
                                </select>
                            </div>
                            
                            <input type="hidden" id='CityValuesForPDF' name='ValuesForPDF' value="<?php echo htmlentities(json_encode($CityTypeValues)); ?>">
                            <input type="hidden" id='CityValuesForCSV' name='CityValuesForCSV' value="<?php echo htmlentities(json_encode($CityTypeValues)); ?>">
                            <input type="hidden" id='ImageURLForPDF' name='ImageURLForPDF'>
                            
                            <div id="SummaryContent">
                                <button type="button" onClick='submitCityReports()' class="fancy-button" style="float: right"> Print Summary </button>
                            </div>
                        </form>
                        
                        <script>
                            function submitCityReports() {
                                if (document.getElementById('CityReportType').value == 'PDF') {
                                    document.getElementById("CityReportForm").action = '../modules/reportPDF.php';
                                    document.getElementById("CityReportForm").submit();
                                } else {
                                    document.getElementById("CityReportForm").action = 'City.php';
                                    document.getElementById("CityReportForm").submit();
                                }
                            }
                        </script>
                        <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST' ){
                                $Headings = ['City','Gas','Electricity'];
                                if (isset($_POST['ReportType']) && $_POST['ReportType'] == 'CSV') {
                                    $JsonData = html_entity_decode($_POST['CityValuesForCSV']);
                                    $CityValues = json_decode($JsonData);
                                }
                                
                                $CityValuesinArray = [];
                                foreach ($CityValues as $ConsumeType => $CityConsumes){
                                    // ['City','Electricity','Gas']
                                    foreach ($CityConsumes as $City => $CityConsumeValue) {
                                        if (!isset($CityValuesinArray[$City])) {
                                            $CityValuesinArray[$City] = [];
                                        }
                                        // EG [GOOR][ELECTRICITY,GAS][241241,321454]
                                        $CityValuesinArray[$City][$ConsumeType] = $CityConsumeValue;
                                    }
                                }
                                $fp = fopen('../Reports/Report.csv', 'w');
                                fputcsv($fp,$Headings); 
                                foreach ($CityValuesinArray as $City => $ConsumeValues){
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
                                            document.getElementById("my_iframe").src = "../Reports/CityReport.csv";
                                        </script>
                                    '
                                ;
                            }
                        ?>
                    </div>
                </div>
            </div>
            
            <!-- 🗺️ Heatmap -->
            <div class="col-12 col-md-12 d-flex">
                <div class="card h-90">
                    <div class="card-header"> 🗺️ Energy Use Heatmap </div>
                    <div id="heatmap"></div> <!-- 🗺️ Heatmap container -->
                </div>
            </div>
            
        </div>
    </div>
    
    <!-- 👣 Footer -->
    <?php include("../modules/footer.php"); ?>
    
</body>
</html>