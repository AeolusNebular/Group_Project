<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>
    
    <script src="/Group_Project/GroupProject_Group12/scripts/Create_User.js"></script>
    
    <title>Admin - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- 📍 Navbar -->
    <?php include("../modules/navbar.php");
    require('../Database_Php_Interactions/Database_Utilities.php');
    include('../Database_Php_Interactions/CSVData.php'); ?>
    
    <!-- Admin page content -->
    <div class="container-lg mt-4" style="min-height: 800px;">
        
        <!-- 📛 Title -->
        <div class="text-center">
            <h2>Admin</h2>
        </div>
        
        <div class="row" >
            <!-- Big chart panel (fat) -->
            <div class="col-12 col-md-5">
                <div class="card">
                    <div class="card-header">📊 User Creation</div>
                    <div class="card-body">
                        
                        <form id="AdminPanelForm" action="../Database_Php_Interactions/Create_New_User.php" method="POST">
                            <div id="AdminPanelFormContent">
                                <div id="AdminPanelFormContentInputs">
                                    <label for="Email">Email Address:</label><br>
                                    <input type="email" id="Email" name="Email" placeholder="example@email.com">
                                </div>
                                <div id="AdminPanelFormContentInputs">
                                    <label for="Password">Password:</label><br>
                                    <input type="password" id="Password" name="Password">
                                </div>
                                <div id="AdminPanelFormContentInputs" style="margin-bottom: 25px;">
                                    <label for="ConPass">Confirm Password:</label><br>
                                    <input type="password" id="ConPass" name="ConPass">
                                </div>
                            </div>
                            <!-- Network and city assignment code -->
                            <div id="AdminPanelFormRigth">
                                <div style="margin-top: 10px">
                                    <input class="form-check-input" type="checkbox" id="Network_User" name="Network_User" onChange="UserType()">
                                    <label class="form-check-label" for="Network_User">Network user</label> 
                                </div>
                                
                                <div style="margin-top: 10px">
                                    <input class="form-check-input" type="checkbox" id="City_Council_User" name="City_Council_User" onChange="UserType()"> 
                                    <label class="form-check-label" for="City_Council_User">City council user</label> 
                                </div> 
                                    <!-- Network and city select statements -->
                                <div id="Network_Select" style="display: none;" class="themed-dropdown">
                                    <label for="Networks">Select network:</label> <br>
                                    <select class = "form-select" name="Networks" id="Networks">
                                        <option value="Coteq"> Coteq </option>
                                        <option value="Enduris"> Enduris </option>
                                        <option value="Rendo"> Rendo </option>
                                        <option value="Westlandia"> Westlandia </option>
                                        <option value="Enexis"> Enexis </option>
                                        <option value="Stedin"> Stedin </option>
                                        <option value="Liander"> Liander </option>
                                    </select>
                                </div> 

                                <div id="City_Select" style="display: none;" class="themed-dropdown">
                                    <label for="Cities">Select city:</label> <br>
                                    <select class="form-select" name="Cities" id="Cities">
                                            <?php 
                                                include('../Database_Php_Interactions/CitySelect.php'); 
                                            ?>
                                    </select>
                                </div> 

                                <?php 
                                    if (isset($_GET['CreateUser'])) {
                                        if( $_GET['CreateUser']) {
                                            echo"<div Style = 'color: Green'> Account Successfully Created </div>";
                                        } else {
                                            echo"<div Style = 'color: Red'> Account Creation Failed </div>";
                                        }
                                    }  
                                ?>
                                <div id="AdminPanelAddUserBtn">
                                    <button type="submit" class="fancy-button" style="float: right">Add User</button> 
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-7">
                <div class="card">
                    <div class="card-header">📊 Network Users</div>
                    <div class="card-body">
                    
                        <form action="Admin.php" method = 'GET'>
                            <div class="themed-dropdown" style = 'float: left'> 
                                <label for="Networks">Select Year:</label> <br>
                                <select class = "form-select" Onchange = "this.form.submit()" name="Admin_Network_Year" id="Admin_Network_Year">
                                    <option value="2016"> 2016 </option>
                                    <option value="2017"> 2017 </option>
                                    <option value="2018"> 2018 </option>
                                    <option value="2019"> 2019 </option>
                                    <option value="2020"> 2020 </option>
                                </select>
                            </div>
                            <div class="themed-dropdown" style = 'float: right'>
                                <label for="Networks">Select Type:</label> <br>
                                <select class = "form-select" Onchange = "this.form.submit()" name="Admin_Network_Type" id="Admin_Network_Type">
                                    <option value="electricity"> Electricity </option>
                                    <option value="gas"> Gas </option>                                      
                                </select>
                            </div>
                        </form>
                            

                        <canvas id="NetworkCanvas" width="400px" height="150px"></canvas>

                            <?php 
                                // Checks if the requested method has been run aka A form submit
                                if ($_SERVER['REQUEST_METHOD'] == "GET") {
                                    
                                    // Checks if The Year has been selected or assigns it a default
                                    $Year = isset($_GET['Admin_Network_Year']) ? $_GET['Admin_Network_Year'] : '2016';
                                    // Checks if The Type has been selected or assigns it a default 
                                    $Type = isset($_GET['Admin_Network_Type']) ? $_GET['Admin_Network_Type'] : 'electricity';
                                                                      
                                    //Assigns Network variable required for the CSV to display and use in the javascript Graph
                                    $Networks = ['coteq' , 'enexis' , 'liander' , 'stedin' , 'westland-infra'];                                                                      
                                    $NetworkConsumeTotals = array('coteq' => 0,'enexis' => 0,'liander' => 0,'stedin' => 0,'westland-infra' => 0);


                                    //iterates through the array of Networks and Grabs the Value to be assigned to the NetworkConsumeTotals for the Graph Display
                                    foreach ($Networks as $Network) {
                                        // Runs CSVData with assigned variables and grabs data from said CSV File
                                        $Values = CSVData($Type,$Year,$Network);
                                        
                                        // Values = Key(City Name) + Annual Consume(0) + Num of Connections(1)  
                                        foreach ($Values as $Value) {
                                            //Assigns Annual Consume to the Selected Network in Loop
                                            $NetworkConsumeTotals[$Network] += $Value[0];
                                        }                                        
                                    }
                                
                                }
                            ?>
                        
                        <script> 
                            // Grabs the Network consume from Php code above using JSON Encode function and assigns it to data
                            var data = <?php echo json_encode($NetworkConsumeTotals); ?>; 
                            
                            document.addEventListener("DOMContentLoaded", function () {
                                drawDoughnut();
                                window.addEventListener("resize", drawDoughnut); // ✅ Attach resize event once
                            });

                        function drawDoughnut() {
                            let font = { family: "Space Grotesk"};
                            let textColor = theme ? "#000" : "#fff";

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
                        }
                        </script>
                    </div>
                </div>
            </div>
            
            <!-- 🌃 City councils diagram -->
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">🌃 City Council Diagram</div>
                    <div class="card-body">
                    
                        <!-- 🌃 City filter -->
                        <div id = "SummaryContent">Filter by city:
                            <form action="/Group_Project/GroupProject_Group12/Pages/Admin.php" method="GET" class="themed-dropdown">
                                <select name="AdminCityFilter" onChange="this.form.submit()"> 
                                    <option value="all">All</option>
                                    <?php 
                                        include('../Database_Php_Interactions/CitySelect.php'); 
                                    ?>
                                </select>
                            </form>
                        </div>
                        
                        <!-- 📊 City councils chart -->
                        <canvas id="AdminCityCouncilCanvas"></canvas>

                        <?php
                            $Year = isset($_GET['AdminNetworkYear']) ? $_GET['AdminNetworkYear'] : '2016';
                            $City = isset($_GET['AdminCityFilter']) ? $_GET['AdminCityFilter'] : '';
                            $Type = 'electricity';
                            $Networks = ['coteq' , 'enexis' , 'liander' , 'stedin' , 'westland-infra']; 
                            
                            $CityValues = [];

                            foreach ($Networks as $Network) {
                                $CityGraphValues = CSVData($Type,$Year,$Network);

                                foreach ($CityGraphValues as $Key => $City) {                                     
                                    $CityValues[$Key] =  $City[0];
                                }                         
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
                            let textColor = theme ? "#000" : "#fff";

                            const citycanvas = document.getElementById("AdminCityCouncilCanvas");
                            
                            // ✅ Ensure the canvas context is fresh
                            if (!citycanvas) return; // Exit if canvas is missing
                            const ctx = citycanvas.getContext("2d");

                            // 💥 Destroy existing chart properly
                           // if (chartInstance) {
                           //     chartInstance.destroy();
                           //     chartInstance = null; // 🧹 Clear instance reference
                          //  }

                            chartInstance = new Chart(ctx, {
                                type: "bar",
                                data: {
                                    labels: Object.keys(citydata),
                                    datasets: [{
                                        label: "Electricity",
                                        data: Object.values(citydata) ,
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
            
            <div class="col-12 col-md-8">
                <div class="card" style="height: 90%">
                    <div class="card-header">Report Details</div>
                    <div class="card-body">
                        <div style="float: left">
                            <div class="SummaryContent">Filter options:</div>
                        </div>
                        <table>
                               <?php 
                                if ($_SERVER['REQUEST_METHOD'] == "GET" && (isset($_GET['AdminCityFilter']))) {
                                    $Type = 'electricity';
                                    $Year = '2016';
                                    $Network = 'coteq';

                                    $Values = CSVData($Type,$Year,$Network);
                                                            
                                    if (isset($Values) && (!$Values == [])){
                                        echo 
                                        '<tr>
                                        <th>city</th>
                                        <th>annual Cost</th>
                                        <th>Type of connection</th>
                                        <th>Num of connection</th>
                                        </tr>';
                                        
                                     
                                        foreach ($Values as $Key => $City) {
                                            echo '<tr>
                                                  <td> ' . $Key . '</td>';
                                            foreach ($City as $y) {
                                                       
                                               echo '<td>' . $y .'</td>';
                                            }
                                            echo '</tr>';
                                        }
                                    }
                                }
                                ?>
                                
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
</body>
</html>