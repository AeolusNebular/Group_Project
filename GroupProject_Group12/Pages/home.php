<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>
    
    <title> Home - Smart Energy Dashboard </title>
</head>

<body>
    
    <!-- 📍 Navbar and login -->
    <?php 
        include("../modules/navbar.php");
        include("../modules/login.php");
        require_once('../Database_Php_Interactions/Database_Utilities.php');
        include('../Database_Php_Interactions/CSVData.php');
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
                        
                        <!-- 📨 Fetch graph scripts -->
                        <?php include("../scripts/graph.php"); ?>
                        
                        <!-- ✏️ Draw desired graph -->
                        <canvas id="dashboardCanvas"></canvas>
                        
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
                    <div class="card-header"> 🗺️ Energy Use Heatmap </div>
                    <div id="heatmap"></div> <!-- 🗺️ Heatmap container -->
                    <div id="card" style="position: absolute; bottom: 8px; left: 8px; z-index: 2;">
                        <div class="card-header">Intensity</div>
                        <div class="card-body">
                            <ul class="legend-labels">
                            <li><span style="background:#ff0000;"></span>High</li>
                            <li><span style="background:#ffff00;"></span>Medium</li>
                            <li><span style="background:#00ff00;"></span>Low</li>
                            </ul>
                        </div>
                    </div>
                    <style>
                        #legend {
                            position: absolute; bottom: 8px; left: 8px;
                            background: var(--card-dark);
                            padding: 8px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            
                        }
                        .legend-title {
                            font-weight: bold;
                            margin-bottom: 5px;
                        }
                        .legend-scale ul {
                            list-style: none;
                            padding: 0;
                            margin: 0;
                        }
                        .legend-scale ul li {
                            display: flex;
                            align-items: center;
                            margin-bottom: 5px;
                        }
                        .legend-scale ul li span {
                            display: inline-block;
                            width: 20px;
                            height: 20px;
                            margin-right: 5px;
                        }
                    </style>
                </div>
            </div>
            
        </div>
    </div>
    
    <!-- 👣 Footer -->
    <?php include("../modules/footer.php"); ?>
    
</body>
</html>