<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>
    
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
                    <div class="card-header">
                        <span>📊 User Summary</span>
                    </div>
                    <div class="card-body" style="height:350px;">
                    <!-- Profile Section -->
                    <div class="d-flex align-items-center mb-3">
                        <!-- Profile Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 8a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM1 14s1-4 7-4 7 4 7 4H1z"/>
                        </svg>
                        <div class="ms-3">
                            <h5 class="mb-0">Bob Smith</h5>
                            <small>bobsmith@boibsmith.com</small>
                        </div>
                    </div>

                    <!-- Budget Summary -->
                    <div>
                        <hr>
                        <p>💰 <b>Total Budget Tracked:</b> £12,345.67</p>
                        <p>🛒 <b>Last Transaction:</b> £2.89 at <b>Waitrose and Partners</b> <small>(3 hours ago)</small></p>
                        <p>📅 <b>Member Since:</b> January 2025 <small>(2 months ago)</small></p>
                        <hr>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-danger">
                            🗑️ <span class="ms-1">Delete Account</span>
                        </button>
                        <button class="btn btn-warning">
                            🔄 <span class="ms-1">Reset Password</span>
                        </button>
                    </div>
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