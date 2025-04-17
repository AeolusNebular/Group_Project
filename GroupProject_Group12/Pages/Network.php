<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>
    
    <title> Network - Smart Energy Dashboard </title>
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
    
    <!-- 🌐 Network page content -->
    <div class="container mt-4">
        
        <!-- 📛 Title -->
        <div class="text-center">
            <h2>
                <?php 
                    debug_to_console($RoleID);
                    switch ($RoleID) {
                    case '1' :
                        echo 'Network - Admin';
                        break; 
                    case '2' : 
                        echo 'Network - ' . $RoleNetwork;
                        break;
                    }
                ?>
            </h2>
        </div>
        
        <div class ="row gx-1">
            <div class="col-12 d-flex">
                <div class="card">
                    <div class="card-header">
                        City Chart for Network
                        <?php 
                            if ($RoleID == 2) {
                                echo $RoleNetwork;
                            } else {
                                echo ' - Admin';
                            }
                        ?>
                    </div>
                    <div class="card-body">
                        <form action="" method="GET">
                            
                            <!-- ⚙️ Define dropdown options -->
                            <?php
                                $NetworkYearFilter = isset($_GET['NetworkYearFilter']) ? $_GET['NetworkYearFilter'] : '2016';
                                $NetworkName = isset($_GET['NetworkName']) ? $_GET['NetworkName'] : 'coteq';
                                $TypeFilter = isset($_GET['TypeFilter']) ? $_GET['TypeFilter'] : 'Electricity';
                            ?>
                            
                            <!-- 📅 Year dropdown -->
                            <div class="themed-dropdown" style="float: left">
                                <label for="NetworkYearFilter"> Select year: </label> <br>
                                <select class="form-select" name="NetworkYearFilter" id="NetworkYearFilter">
                                    <?php populateYearDropdown($NetworkYearFilter); ?>
                                </select>
                            </div>
                            
                            <!-- 🌐 Network dropdown (for admin users) -->
                            <?php if ($RoleID != 2): ?>
                                <div class="themed-dropdown" style="float: left">
                                    <label for="NetworkName"> Select network: </label><br>
                                    <select class="form-select" name="NetworkName" id="NetworkName">
                                        <?php populateNetworkDropdown($NetworkName, "counciltype"); ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                            
                            <!-- 🔌 Utility dropdown -->
                            <div class="themed-dropdown" style="float: left">
                                <label for="TypeFilter"> Select type: </label> <br>
                                <select class="form-select" name="TypeFilter" id="TypeFilter">
                                    <?php populateUtilityDropdown($TypeFilter, "counciltype"); ?>
                                </select>
                            </div>
                            
                            <!-- ✅ Submit button -->
                            <button type="submit" class="fancy-button" style='margin-top: 15px; float: right;'>
                                Apply Filter
                            </button>
                        </form>
                        
                        <!-- ✏️ Draw desired graph -->
                        <canvas id="cityCanvasNetwork"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-7 d-flex">
                <div class="card">
                    <div class="card-header"> Additional Information </div>
                    <div class="card-body">                     
                        <div id="SummaryContent"> Number of connections: <?php echo json_encode(round($AllNetworkValueByType['Electricity']['Connection'] + $AllNetworkValueByType['Gas']['Connection'] )) ?> </div>
                        <div id="SummaryContent"> Amount of electricity used (kWh): <?php echo json_encode($AllNetworkValueByType['Electricity']['Annual']) ?> </div>
                        <div id="SummaryContent"> Amount of gas used (m<sup>3</sup>): <?php echo json_encode($AllNetworkValueByType['Gas']['Annual']) ?></div>
                        <div id="SummaryContent"> Delivery percentage: <?php echo json_encode(round($AllNetworkValueByType['Electricity']['Delivery_Perc'] + $AllNetworkValueByType['Gas']['Delivery_Perc'] )) ?></div>
                        <div id="SummaryContent"> <br> </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-5 d-flex">
                <div class="card">
                    <div class="card-header"> Filter options: </div>
                    <div class="card-body">
                    <form id="NetworkReportForm" method = "POST">
                        <div class="themed-dropdown" style='float: left'>
                            <label for="NetworkReportType"> Report type: </label> <br>
                            <select class="form-select" id="NetworkReportType" name="NetworkReportType">
                                <option value="PDF"> PDF </option>
                                <option value="CSV"> CSV </option>
                            </select>
                        </div>

                        <input type="hidden" id='NetworkValuesForPDF' name='ValuesForPDF' value="<?php echo htmlentities(json_encode($NetworkValueByType)); ?>">
                        <input type="hidden" id='NetworkValuesForCSV' name='NetworkValuesForCSV' value="<?php echo htmlentities(json_encode($NetworkValueByType)); ?>">
                        <input type="hidden" id='ImageURLForPDF' name='ImageURLForPDF'>

                        <div id="SummaryContent">
                            <button type="button" onClick='submitNetworkReports()' class="fancy-button" style="float: right"> Print Summary </button>
                        </div>
                    </form>
                        
                        <script>
                            function submitNetworkReports() {
                                if (document.getElementById("NetworkReportType").value == 'PDF') {
                                    document.getElementById("NetworkReportForm").action = '../modules/reportPDF.php';
                                    document.getElementById("NetworkReportForm").submit();
                                } else {
                                    document.getElementById("NetworkReportForm").action = 'Network.php';
                                    document.getElementById("NetworkReportForm").submit();
                                }
                            }
                        </script>
                        <?php 
                            if ($_SERVER['REQUEST_METHOD'] == 'POST' && (isset($_POST['NetworkReportType']) && $_POST['NetworkReportType'] == 'CSV')) {
                                $Headings = ['City','Gas','Electricity'];
                                $JsonData = html_entity_decode($_POST['NetworkValuesForCSV']);
                                $NetworkValues = json_decode($JsonData);
                                
                                $NetworkValuesInArray = [];
                                foreach ($NetworkValues as $ConsumeType => $NetworkConsumes){
                                    // ['City','Electricity','Gas']
                                    foreach ($NetworkConsumes as $City => $NetworkConsumeValue) {
                                        if (!isset($NetworkValuesinArray[$City])) {
                                            $NetworkValuesinArray[$City] = [];
                                        }
                                        // eg [GOOR][ELECTRICITY,GAS][241241,321454]
                                        $NetworkValuesinArray[$City][$ConsumeType] = $NetworkConsumeValue;
                                    }
                                }
                                $fp = fopen('../Reports/NetworkReport.csv', 'w');
                                fputcsv($fp,$Headings);
                                foreach ($NetworkValuesinArray as $City => $ConsumeValues){
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
                                        document.getElementById("my_iframe").src = "../Reports/NetworkReport.csv";
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
                    <div id="heatmap">
                        <!-- 🗺️ Heatmap container -->
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <!-- 👣 Footer -->
    <?php include("../modules/footer.php"); ?>
    
</body>
</html>