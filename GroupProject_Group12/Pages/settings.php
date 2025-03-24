<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include("../modules/header.php"); ?>
    
    <title>Settings Smart Energy Dashboard</title>

    <!-- Add some inline CSS or link to your stylesheet -->
    <style>
        /* Ensure the body covers the entire height of the screen */
        body, html {
            height: 100%;
            margin: 0;
        }
        
        /* Container to center the content */
        .content-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
        }

        /* Optional: If you want to add some space between the content */
        .settings-card-container {
            width: 100%;
            max-width: 600px; /* Adjust to your desired width */
        }
    </style>
</head>
<body>
    
    <!-- 📍 Navbar -->
    <?php include("../modules/navbar.php"); ?>

    <div class="text-center">
        <h2>Settings</h2>
    </div>
    
    <!-- Center the content vertically and horizontally -->
    <div class="content-wrapper">
        <!-- Side panel (thin) -->
        <div class="settings-card-container">
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

</body>
</html>
