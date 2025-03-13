<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Personal Information:</title>
</head>
<body>
    
    <?php include("../modules/navbar.php")?>

    <div style="text-align: center">
        <h2>Personal Information:</h2>
    </div>


    <div class="column" >
            <!-- Big chart panel (fat) -->
            <div class="col-12  col-md-12">
                <div class="card" style="height: 90%">
                    <div class="card-header">Additional User Information</div>
                    <div class="card-body">
                        <div style = "float: left" >
                            <div id = "Content_Inputs">
                                <label for="UserFName">Enter First Name:</label><br>
                                <input type="text" name = "UserFName" >
                            </div>
                            <div id = "Content_Inputs">
                                <label for="UserLName">Enter Last Name:</label><br>
                                <input type="text" name = "UserLName" >
                            </div>
                        </div>
                        <div style = " margin-left: 25px; float: left">
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



</body>
</html>