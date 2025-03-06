<!DOCTYPE html>
<html data-bs-theme="dark" lang="en-gb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../javascripts/sidebar.js"></script>
    <title>Home - Smart Energy Dashboard</title>
</head>

<body>

    <!-- Navbar -->
    <?php include("navbar.php"); ?>
    
    <script>drawChart()</script>
    
    
    <div id="leftwallanim"></div>
    <div id="rightwallanim"></div>
    


    <!-- Panels -->
    <div id="testing" style="margin-left: 48px;">
        
        <div style="text-align: center; width: 100% ">
            <h2>Panels with Contextual Classes</h2>
        </div>


        <div class="panel-group">

            <div class="panel panel-default">
                <div class="panel-heading">Panel</div>
                <div class="panel-body">Panel Content</div>

                <div id="myChart" style="width:100%; max-width:800px; height:400px;"></div>
                
            </div>

            <div class="panel panel-default">
                <div class="panel-body">Panel Content</div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">Panel</div>
                <div class="panel-body">
                    
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">Panel Content</div>
                
            </div>

            <div class="panel panel-default">
                <div class="panel-body">Panel Content</div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">Panel Content</div>
            </div>

        </div>
    </div>

</div>

</body>

</html>