<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>
    
    <title>City Council - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- 📍 Navbar -->
    <?php include("../modules/navbar.php"); ?>
    
    <!-- 🌃 City page content -->
    <div class="container mt-4">
        
        <!-- 📛 Title -->
        <div class="text-center">
            <h2>City</h2>
        </div>
        
        <!-- 🧭 City selection -->
        <div class="btn-group" style="margin-top: 25px; margin-left: 15px;" role="group" >
            <button type="button" class="btn btn-primary">Stedin</button>
            <button type="button" class="btn btn-primary">Liander</button>
            <button type="button" class="btn btn-primary">Coteq</button>
            <button type="button" class="btn btn-primary">Enduris</button>
            <button type="button" class="btn btn-primary">Rendo</button>
            <button type="button" class="btn btn-primary">Westlandinfra</button>
            <button type="button" class="btn btn-primary">Enexis</button>
        </div>
        
        <!-- 📈 Network graph -->
        <div class="row">
            <div class="col-12 col-md-7">
                <div class="card">
                    <div class="card-header">📊 Network Graph</div>
                    <div class="card-body">
                        <canvas id="testChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- 📅 Annual summary -->
            <div class="col-12 col-md-5">
                <div class="card">
                    <div class="card-header">📅 Annual Summary</div>
                    <div class="card-body">
                        <div id = "SummaryContent">Number of Connections: </div>
                        <div id = "SummaryContent">Electricity Used (kWh): </div>
                        <div id = "SummaryContent">Gas Used (m<sup>3</sup>): </div>
                        <div id = "SummaryContent">Delivery Percentage: </div>
                        <div id = "SummaryContent">Connections Types: </div>
                        <div id = "SummaryContent">Connection Type Percentages: </div>
                        <div id = "SummaryContent">
                            <button type="button" class="fancy-button" style="float: right">Print Summary</button>
                        </div>
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