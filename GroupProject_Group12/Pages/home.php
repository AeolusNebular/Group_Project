<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("modules/header.php"); ?>
    
    <title>Home - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- 📍 Navbar -->
    <?php include("modules/navbar.php"); ?>
    
    <!-- 🏠 Home page content (dashboard) -->
    <div class="container mt-4">

        <!-- 📛 Title -->
        <div class="text-center">
            <h2>Dashboard</h2>
        </div>
        
        <div class="row">
            <!-- 📈 Big chart panel (fat) -->
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">📊 Energy Usage Overview</div>
                    <div class="card-body" style="height:350px;">
                        <canvas id="testChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Side panel (thin) -->
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header">⚡ Latest Energy Stats</div>
                    <div class="card-body" style="height:350px;">
                        <p><strong>Usage:</strong> 1,250 kWh</p>
                        <p><strong>Efficiency:</strong> 85%</p>
                        <p><strong>Cost:</strong> £120</p>
                    </div>
                </div>
            </div>
            
            <!-- Two even cards -->
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">🔍 Analysis</div>
                    <div class="card-body">
                        <p>Last month saw a <strong>15% decrease</strong> in energy consumption.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">⚙️ Recommendations</div>
                    <div class="card-body">
                        <ul>
                            <li>Switch to <strong>LED lighting</strong>.</li>
                            <li>Optimise heating settings.</li>
                            <li>Use smart plugs.</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Full-width bottom card -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">⚠️ Warning</div>
                    <div class="card-body">
                        Your energy consumption is <strong>15% above</strong> the expected range this month. Holy guacamole!!
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