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
            <div class="text-center">
                <h2>Settings</h2>
            </div>
            
            <!-- Side panel (thin) -->
            <div class="col-12 col-md-6">
                <!-- 🎨 Customisability options -->
                <div class="card">
                    <div class="card-header">⚙️ User Settings</div>
                    <div class="card-body">
                        <ul>
                            
                            <li>
                                <label for="darkMode">Dark mode:</label>
                                <select id="darkMode" class="form-select">
                                    <option value="auto">Auto</option>
                                    <option value="light">Light</option>
                                    <option value="dark">Dark</option>
                                </select>
                            </li>
                            <li>
                                <input type="checkbox" id="darkModeNavbar" class="form-check-input">
                                <label for="darkModeNavbar">Show dark mode toggle in navbar</label>
                            </li>
                            <li>
                                <label for="fontSize">Font size:</label>
                                <select id="fontSize" class="form-select">
                                    <option value="default">Default</option>
                                    <option value="large">Large</option>
                                    <option value="extra-large">Extra large</option>
                                </select>
                            </li>
                            <li>
                                <input type="checkbox" id="highContrast" class="form-check-input">
                                <label for="highContrast">High contrast</label>
                            </li>
                            <li>
                                <input type="checkbox" id="limitAnimations" class="form-check-input">
                                <label for="limitAnimations">Limit screen animations</label>
                            </li>
                            <li>
                                <label for="theme">Theme selection:</label>
                                <select id="theme" class="form-select">
                                    <option value="default">Default</option>
                                    <option value="deuteranopia">Deuteranopia</option>
                                    <option value="tritanopia">Tritanopia</option>
                                    <option value="achromatopsia">Achromatopsia</option>
                                </select>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

</body>
</html>