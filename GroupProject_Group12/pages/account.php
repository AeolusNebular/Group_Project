<!-- filepath: c:\xampp\htdocs\Group_Project\GroupProject_Group12\Pages\account.php -->
<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>
    
    <title>Account - Smart Energy Dashboard</title>
    <script src="../scripts/themes.js"></script> <!-- Include the themes.js file -->
</head>

<body>
    
    <!-- 📍 Navbar -->
    <?php include("../modules/navbar.php"); ?>
    
    <!-- 👤 Account page content -->
    <div class="container mt-4">
        
        <!-- 📛 Title -->
        <div class="text-center">
            <h2>Account</h2>
        </div>
        
        <div class="row">
            <!-- 📝 User summary panel (fat) -->
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        📝 User Summary
                    </div>
                    <div class="card-body" style="height:350px;">
                        <div class="d-flex align-items-center mb-3">
                            <!-- 👤 Profile -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 8a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM1 14s1-4 7-4 7 4 7 4H1z"/>
                            </svg>
                            <div class="ms-3">
                                <h5 class="mb-0">Bob Smith</h5>
                                <small>bobsmith@boibsmith.com</small>
                            </div>
                        </div>
                        
                        <!-- 💰 Budget summary -->
                        <div>
                            <hr>
                            <p>💰 <b>Phone Number:</b> 06564 885443</p>
                            <p>🛒 <b>Address:</b> 88446 Waitrose Road</p>
                            <p>📅 <b>Role:</b> City Council</p>
                            <hr>
                        </div>
                        
                        <!-- 🏃‍♂️ Action buttons -->
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-danger">🗑️ Delete Account</button>
                            <button class="btn btn-warning">🔄 Reset Password</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- ➕ Side panel (thin) -->
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header">➕ Additional User Information</div>
                    <div class="card-body" style="height:350px;">
                        <form>
                            <div class="mb-2">
                                <label for="UserFName" class="form-label">First name:</label>
                                <input type="text" id="UserFName" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="UserLName" class="form-label">Last name:</label>
                                <input type="text" id="UserLName" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="UserPhoneNo" class="form-label">Phone number:</label>
                                <input type="tel" id="UserPhoneNo" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label for="UserHomeNo" class="form-label">Home address:</label>
                                <input type="text" id="UserHomeNo" class="form-control">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- 🛸 Spacer and line -->
            <div>
                <br>
                <hr>
            </div>
            
            <!-- 📛 Title -->
            <div class="text-center">
                <h2>Settings</h2>
            </div>
            
            <!-- ⚙️ Side panel (thin) -->
            <div class="col-12 ">
                <!-- 🎨 Customisability options -->
                <div class="card">
                    <div class="card-header">⚙️ User Settings</div>
                    <div class="card-body">
                        <ul>
                            <li>
                                <label for="darkMode">Dark mode:</label>
                                <div class="themed-dropdown">
                                    <select id="darkMode" class="form-select">
                                        <option value="auto">Auto</option>
                                        <option value="light">Light</option>
                                        <option value="dark">Dark</option>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <input type="checkbox" id="darkModeNavbar" class="form-check-input" checked>
                                <label for="darkModeNavbar">Show dark mode toggle in navbar</label>
                            </li>
                            <li>
                                <label for="fontSize">Font size:</label>
                                <div class="themed-dropdown">
                                    <select id="fontSize" class="form-select">
                                        <option value="default">Default</option>
                                        <option value="large">Large</option>
                                        <option value="extra-large">Extra large</option>
                                    </select>
                                </div>
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
                                <label for="colorblind">ColourBlind Stuff:</label>
                                <div class="themed-dropdown">
                                    <select id="colorblind" class="form-select">
                                        <option value="default">Default</option>
                                        <option value="deuteranopia">Deuteranopia</option>
                                        <option value="tritanopia">Tritanopia</option>
                                        <option value="achromatopsia">Achromatopsia</option>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <label for="theme">Theme selection:</label>
                                <div class="themed-dropdown">
                                    <select onchange="CheckTheme(this.value)" id="theme" class="form-select">
                                        <option value="purple">Purple</option>
                                        <option value="green">Green</option>
                                        <option value="blue">Blue</option>
                                        <option value="achromatopsia">Achromatopsia</option>
                                    </select>
                                </div>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

</body>
</html>