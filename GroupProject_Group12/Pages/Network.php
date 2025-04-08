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
    require_once('../Database_Php_Interactions/Database_Utilities.php');
    include('../Database_Php_Interactions/CSVData.php'); ?>
    
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
                <div class="card h-90">
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
                        <form action="Network.php" method="POST">
                            <div class="themed-dropdown" style="float: left">
                                <label for="TypeFilter"> Filter by type: </label>
                                <select class="form-select" id="TypeFilter" name="TypeFilter">
                                    <option value="Gas"         <?= ($_POST['TypeFilter'] ?? '') === 'Gas'         ? 'selected' : '' ?>> Gas </option>
                                    <option value="Electricity" <?= ($_POST['TypeFilter'] ?? '') === 'Electricity' ? 'selected' : '' ?>> Electricity </option>
                                </select>
                            </div>
                            <?php if ($RoleID != 2): ?>
                                <div class="themed-dropdown" style="float: left">
                                    <label for="NetworkName"> Select network: </label><br>
                                    <select class="form-select" id="NetworkName" name="NetworkName">
                                        <option value="coteq"          <?= ($_POST['NetworkName'] ?? '') === 'coteq'          ? 'selected' : '' ?>> Coteq </option>
                                        <option value="westland-infra" <?= ($_POST['NetworkName'] ?? '') === 'westland-infra' ? 'selected' : '' ?>> Westlandia </option>
                                        <option value="enexis"         <?= ($_POST['NetworkName'] ?? '') === 'enexis'         ? 'selected' : '' ?>> Enexis </option>
                                        <option value="stedin"         <?= ($_POST['NetworkName'] ?? '') === 'stedin'         ? 'selected' : '' ?>> Stedin </option>
                                        <option value="liander"        <?= ($_POST['NetworkName'] ?? '') === 'liander'        ? 'selected' : '' ?>> Liander </option>
                                    </select>
                                </div>
                            <?php endif; ?>
                            <div class="themed-dropdown" style="float: left">
                                <label for="NetworkYearFilter"> Filter by year: </label>
                                <select class="form-select" id="NetworkYearFilter" name="NetworkYearFilter">
                                    <?php
                                        foreach ([2016, 2017, 2018, 2019, 2020] as $year) {
                                            $selected = ($_POST['NetworkYearFilter'] ?? '') == $year ? 'selected' : '';
                                            echo "<option value=\"$year\" $selected>$year</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                            <button type="Submit" class="fancy-button" style='margin-top: 15px; float: right;'>
                                Apply Filter
                            </button>
                        </form>
                        
                        <!-- 📨 Fetch graph scripts -->
                        <?php include("../scripts/graph.php"); ?>
                        
                        <!-- ✏️ Draw desired graph -->
                        <canvas id="cityCanvasNetwork"></canvas>
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
                            <select class="form-select" id="ReportCityFilterNetwork">
                                <option value="all"> All </option>
                                <?php 
                                    include('../Database_Php_Interactions/CitySelect.php');
                                ?>
                            </select>
                        </div>
                        
                        <div id="SummaryContent" class="themed-dropdown"> Filter report by utility: 
                            <select class="form-select" id="Gas_Electricity_Both">
                                <option value="Both">        All </option>
                                <option value="Gas">         Gas </option>
                                <option value="Electricity"> Electricity </option>
                            </select>
                        </div>
                        
                        <div id="SummaryContent">
                            <button type="button" class="fancy-button" style="float: right"> Print Summary </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 🗺️ Heatmap -->
            <div class="col-12 col-md-12 d-flex">
                <div class="card h-90">
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