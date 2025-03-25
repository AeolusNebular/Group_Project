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
                        <span>📝 User Summary</span>
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
                            <p>💰 <b>Total Budget Tracked:</b> £12,345.67</p>
                            <p>🛒 <b>Last Transaction:</b> £2.89 at <b>Waitrose and Partners</b> <small>(3 hours ago)</small></p>
                            <p>📅 <b>Member Since:</b> January 2025 <small>(2 months ago)</small></p>
                            <hr>
                        </div>
                        
                        <!-- 🏃‍♂️ Action buttons -->
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-danger">
                                🗑️ Delete Account
                            </button>
                            <button class="btn btn-warning">
                                🔄 Reset Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- ➕ Side panel (thin) -->
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header">➕ Additional User Information</div>
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
                                     <select  id="darkMode" class="form-select">
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
                                 <label for="theme">Theme selection:</label>
                                 <div class="themed-dropdown">
                                     <select id="theme" class="form-select">
                                         <option value="default">Default</option>
                                         <option value="deuteranopia">Deuteranopia</option>
                                         <option value="tritanopia">Tritanopia</option>
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