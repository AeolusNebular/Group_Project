<!DOCTYPE html>
<html lang="en-gb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>City Council - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- Navbar -->
    <?php include("../modules/navbar.php"); ?>
    
    <div id="testing">
        
        <div style="text-align: center">
            <h2>City Name:</h2>
        </div>

        <div class="btn-group" style = "margin-top: 25px; margin-left: 15px;" role = "group" >
            <button type = "button" class="btn btn-primary">Stedin</button>
            <button type = "button" class="btn btn-primary">Liander</button>
            <button type = "button" class="btn btn-primary">Coteq</button>
            <button type = "button" class="btn btn-primary">Enduris</button>
            <button type = "button" class="btn btn-primary">Rendo</button>
            <button type = "button" class="btn btn-primary">Westlandinfra</button>
            <button type = "button" class="btn btn-primary">Enexis</button>
        </div>
        
        <div class="row">
            <div class="col-12  col-md-7">
                <div class="card" style="height: 90%">
                    <div class="card-header">📊 Network Graph:</div>
                        <div class="card-body" >
                            <canvas id = "testChart"></canvas>
                        </div>
                </div>
            </div>
            <div class="col-12  col-md-5" >
                <div class="card" style="height: 90%">
                    <div class="card-header">Year Summary:</div>
                    <div class="card-body" >
                        <div id = "SummaryContent">Number of Connections:</div>
                        <div id = "SummaryContent">Amount of Electricity Used(kWh):</div>
                        <div id = "SummaryContent">Amount of Gas Used (m3):</div>
                        <div id = "SummaryContent">Delivery Percentage: </div>
                        <div id = "SummaryContent">Types of Connections: </div>
                        <div id = "SummaryContent">Types Connections Percentage: </div>
                        
                        <div id = "SummaryContent">
                            <button type = "button" class = "btn" style = "color: white; float: right">Print Summary</button>
                        </div>
                    </div>

                    
                </div>
            </div>
            <div class="col-12  col-md-12" >
                <div class="card" style="height: 90%">
                    <div class="card-header">Potential Heatmap:</div>
                    <img src="/Group_Project/GroupProject_Group12/Images/Placeholder_Heatmap.jpg" alt="PotentialHeatmap">
                </div>
            </div>
        </div>

        
      
    </div>

    
</body>




</html>