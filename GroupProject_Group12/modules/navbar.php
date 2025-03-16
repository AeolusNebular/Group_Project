<!DOCTYPE html>
<html lang="en-gb">

<body>
    
    <!-- Navbar -->
    <nav class="navbar">
        
        <!-- Vertical navbar toggle button with aria controls for accessibility -->
        <button class="navbar-toggler" type="button" onclick="toggleNav()" aria-label="Toggle navigation" aria-controls="mySidebar">
            <span class="navbar-toggle-icon"></span> 
        </button>
        
        <h2>Smart Energy Dashboard</h2>
        
        <div class="icon-container">
            <div class="icon-container">
                <button onclick="toggleDarkLight()" id="darkModeToggle" class="btn" 
                    style="margin-right: 8px;" 
                    aria-label="Toggle Dark Mode"> 
                    <svg id="darkModeIcon" xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" class="bi bi-moon-stars-fill" viewBox="0 0 16 16">
                        <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>
    
    <!-- Sidebar -->
    <nav id="main">
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
                <br><br><br>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/Group_Project/GroupProject_Group12/pages/account.php">Account</a>
                </li>
            </ul>
            
            <div style="position: absolute; bottom: 64px; right: 48px;">
                <button type='button' class="fancy-button" onclick="window.location.href='/Group_Project/GroupProject_Group12/pages/login.php'">Login</button>
            </div>
        </div>
    </nav>
    
</body>
</html>