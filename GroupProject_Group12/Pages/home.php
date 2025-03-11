<!DOCTYPE html>
<html lang="en-gb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <link rel="stylesheet" href="/Group_Project/GroupProject_Group12/style.css">

    <!-- chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="/Group_Project/GroupProject_Group12/scripts/sidebar.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/graph.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/darkmode.js"></script>


    <title>Home - Smart Energy Dashboard</title>
</head>

<body>

    <!-- Navbar -->
    <?php include("navbar.php"); ?>

   

    <!-- Dashboard Content -->
    <div class="container mt-4" id="testing">
        <div class="text-center">
            <h2>Energy Usage Overview</h2>
        </div>

        <div class="row">
            <!-- Big chart panel (fat) -->
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">📊 Energy Chart</div>
                    <div class="card-body" style="height:350px;">
                        <canvas id="myChart"></canvas>
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
                            <li>Switch to LED lighting.</li>
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
                        Your energy consumption is **15% above** the expected range this month. Holy guacamole!!
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>