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
        include('../modules/dropdowns.php');
        require_once('../Database_Php_Interactions/Database_Utilities.php');
        include('../Database_Php_Interactions/CSVData.php');
        include("../scripts/graph.php");
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
                <div class="card">
                    <div class="card-header"> 📊 Network Graph </div>
                    <div class="card-body">
                        
                        <form action="" method='GET'>
                            
                            <!-- ⚙️ Define dropdown options -->
                            <?php
                                $CityYears = isset($_GET['CityYears']) ? $_GET['CityYears'] : '2016';
                                $CityNetworks = isset($_GET['CityNetworks']) ? $_GET['CityNetworks'] : 'Electricity';
                            ?>
                            
                            <!-- 📅 Year dropdown -->
                            <div class="themed-dropdown" style="float: left">
                                <label for="CityYears"> Select year: </label> <br>
                                <select class="form-select" name="CityYears" id="CityYears">
                                    <?php populateYearDropdown($CityYears); ?>
                                </select>
                            </div>
                            
                            <!-- 🌐 Network dropdown (for admin users) -->
                            <?php if ($RoleID != 2): ?>
                                <div class="themed-dropdown" style="float: left">
                                    <label for="CityNetworks"> Select network: </label><br>
                                    <select class="form-select" name="CityNetworks" id="CityNetworks">
                                        <?php populateNetworkDropdown($CityNetworks, "counciltype"); ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                            
                            <!-- ✅ Submit button -->
                            <button type="submit" class="fancy-button" style='margin-top: 15px; float: right'>
                                Apply Filter
                            </button>
                        </form>
                        
                        <!-- ✏️ Draw desired graph -->
                        <canvas id="cityCanvas"></canvas>
                        
                    </div>
                </div>
            </div>
            
            <!-- 📅 Annual summary -->
            <div class="col-12 col-md-5 d-flex">
                <div class="card">
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
                            if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['CityReportType']) && $_POST['CityReportType'] == 'CSV')){
                                $Headings = ['City','Gas','Electricity'];      
                                $JsonData = html_entity_decode($_POST['CityValuesForCSV']);
                                $CityValues = json_decode($JsonData);
                                
                                
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
                                $fp = fopen('../Reports/CityReport.csv', 'w');
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
                <div class="card">
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