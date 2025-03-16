<!DOCTYPE html>
<html lang="en-gb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/Group_Project/GroupProject_Group12/images/favicon.png">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="/Group_Project/GroupProject_Group12/styles/style.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Leaflet -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://cdn.jsdelivr.net/npm/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <!-- Heatmap.js -->
    <script src="https://cdn.jsdelivr.net/npm/heatmap.js@2.0.0"></script> <!-- STILL SEEMINGLY BROKEN -->
    <script src="https://cdn.jsdelivr.net/npm/leaflet-heatmap/leaflet-heatmap.js"></script>
    
    <!-- Scripts -->
    <script src="/Group_Project/GroupProject_Group12/scripts/sidebar.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/graph.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/darkmode.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/login_modal.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/sparks.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/heatmap.js"></script>
    
    <title>Navbar Module - Smart Energy Dashboard</title>
</head>

<body>
    
    <!-- Navbar - horizontal -->
    <nav class="navbar">
        <button style="float: left; margin-left: 15px" 
            class="navbar-toggler" 
            onclick="toggleNav()">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="icon-container">
            <button onclick="toggleDarkLight()" id="darkModeToggle" class="btn" 
                style="float: right; margin-right: 15px;" 
                aria-label="Toggle Dark Mode"> 
                <svg id="darkModeIcon" xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" class="bi bi-moon-stars-fill" viewBox="0 0 16 16">
                    <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278"/>
                </svg>
            </button>
        </div>
    </nav>
    
    <!-- Navbar - vertical -->
    <nav id="main" style = "position: relative">
        <div class="sidebar" id="mySidebar">
            <ul style="list-style-type: none; width: 30px;">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/Group_Project/GroupProject_Group12/index.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/Group_Project/GroupProject_Group12/pages/city.php">City</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/Group_Project/GroupProject_Group12/pages/network.php">Network</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/Group_Project/GroupProject_Group12/pages/admin.php">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/Group_Project/GroupProject_Group12/Pages/Personal_Information.php">Account</a>
                </li>
            </ul>
            
            <div style="position: absolute; bottom: 64px; right: 48px;">
                <button type='button' class="fancy-button" onclick="window.location.href='/Group_Project/GroupProject_Group12/Pages/Login.php'">Login</button>
            </div>
        </div>
    </nav>
    
</body>
</html>