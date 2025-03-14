<!DOCTYPE html>
<html lang="en-gb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Personal Information:</title>
</head>

<body>
    
    <!-- Navbar -->
    <?php include("../modules/navbar.php"); ?>

    <!-- Accoun page content -->
    <div class="container mt-4" id="testing">
        <div class="text-center">
            <h2>Personal Information</h2>
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
                        <div style = "float: left" >
                            <div id = "Content_Inputs">
                                <label for="UserFName">Enter First Name:</label><br>
                                <input type="text" name = "UserFName" >
                            </div>
                            <div id = "Content_Inputs">
                                <label for="UserLName">Enter Last Name:</label><br>
                                <input type="text" name = "UserLName" >
                            </div>
                            <div id = "Content_Inputs">
                                <label for="UserPhoneNo">Enter Phone Number:</label><br>
                                <input type="tel" name = "UserPhoneNo" >
                            </div>
                            <div id = "Content_Inputs">
                                <label for="UserHomeNo">Enter Home Address:</label><br>
                                <input type="text" name = "UserHomeNo" >
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>