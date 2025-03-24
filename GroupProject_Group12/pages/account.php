<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Account - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- 📍 Navbar -->
    <?php include("../modules/navbar.php"); ?>

    <!-- Account page content -->
    <div class="container mt-4">
        
        <!-- 📛 Title -->
        <div class="text-center">
            <h2>Account</h2>
        </div>
        
        <div class="row">
            <!-- User summary panel (fat) -->
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">📊 User Summary </div>
                    <div class="card-body" style="height:350px;">
                        <canvas id="testChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Side panel (thin) -->
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header">⚡ Additional User Information</div>
                    <div class="card-body" style="height:350px;">
                        <div style="float: left" >
                            <div id="Content_Inputs">
                                <label for="UserFName">First name:</label><br>
                                <input type="text" name="UserFName">
                            </div>
                            <div id="Content_Inputs">
                                <label for="UserLName">Last name:</label><br>
                                <input type="text" name="UserLName">
                            </div>
                            <div id="Content_Inputs">
                                <label for="UserPhoneNo">Phone number:</label><br>
                                <input type="tel" name="UserPhoneNo">
                            </div>
                            <div id="Content_Inputs">
                                <label for="UserHomeNo">Home address:</label><br>
                                <input type="text" name="UserHomeNo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 📛 Title -->
            
            
        </div>
    </div>

</body>
</html>