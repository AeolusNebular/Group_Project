<!DOCTYPE html>
<html lang="en-gb">

<body>
    
    <!-- 📍 Navbar -->
    <nav class="navbar">
        
        <!-- Vertical navbar toggle button (with aria controls for accessibility) -->
        <button class="navbar-toggler" type="button" onclick="toggleNav()" aria-label="Toggle navigation" aria-controls="mySidebar">
            <span class="navbar-toggle-icon"></span> 
        </button>
        
        <h2>Smart Energy Dashboard</h2>
        
        <div>
            <div class="icon-container">
                <!-- 🌙 Dark mode toggler -->
                <button onclick="toggleDarkLight()" id="darkModeToggle" class="btn" 
                    style="margin-right: 8px;" 
                    aria-label="Toggle Dark Mode"> 
                    <svg id="darkModeIcon" xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" class="bi bi-moon-stars-fill" viewBox="0 0 16 16">
                        <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278"/>
                    </svg>
                </button>
            </div>

            <div class="icon-container">
                <!-- 🔔 Notifications icon -->
                <button id="notificationsButton" class="btn" onclick="toggleNotifications()" aria-label="Notifications" style="color: white;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 16 16">
                    <!-- Shorter Bell Body -->
                    <path d="M8 2C5.5 2 3.5 4.5 3.5 7v3c0 .8-.5 1.5-1.2 2h11.4c-.7-.5-1.2-1.2-1.2-2V7c0-2.5-2-5-4.5-5z"/>
                    <!-- Bell Rim -->
                    <path d="M2.5 12c-.8 0-1.5.7-1.5 1.5S1.7 15 2.5 15h11c.8 0 1.5-.7 1.5-1.5S14.3 12 13.5 12h-11z"/>
                    <!-- Circular, Proportionate Clapper -->
                    <circle cx="8" cy="14.5" r="1.4" fill="currentColor"/>
                </svg>
                </button>
            </div>
            
            <div class="icon-container">
                <!-- 👤 Account button with dropdown -->
                <div class="account-menu">
                    <button id="accountButton" class="account-btn" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26px" height="26px" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 8a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM1 14s1-4 7-4 7 4 7 4H1z"/>
                        </svg>
                    </button>
                    
                    <!-- 🚨 TBA: NEW USER VARIANT -->
                    
                    <!-- 🔽 Dropdown menu -->
                    <div id="accountDropdown" class="dropdown">
                        <a href="/Group_Project/GroupProject_Group12/pages/account.php">Profile</a>
                        <a href="/Group_Project/GroupProject_Group12/pages/settings.php">Settings</a>
                        <a href="/Group_Project/GroupProject_Group12/pages/account.php">Logout</a>
                    </div>
                </div>
            </div>
        
        </div>
    </nav>
    
    <!-- 📍 Sidebar -->
    <nav id="main">
        <div class="sidebar" id="mySidebar">
            <ul style="list-style-type: none; width: 30px;">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/Group_Project/GroupProject_Group12/pages/home.php">Dashboard</a>
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
            
            <!-- 🔘 Login button (triggers modal) -->
            <div style="position: absolute; bottom: 64px; right: 48px;">
                <button type="button" class="fancy-button" data-bs-toggle="modal" data-bs-target="#LoginModal">
                    Login
                </button>
            </div>
            
        </div>
    </nav>
    
    <!-- 📍 Notifications Dropdown -->
    <div id="notificationsDropdown" class="dropdown-menu" style="display: none; position: absolute; top: 50px; right: 20px; width: 250px; background-color: #fff; border: 1px solid #ddd; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); padding: 10px; border-radius: 8px;">
        <div id="notificationList" class="notification-list">
            <!-- Notifications will be injected here dynamically -->
            <div class="notification unread">This is a notification!</div>
            <div class="notification">This is another!</div>
        </div>
        
        <!-- ➕ Button to load more notifications -->
        <a href="/Group_Project/GroupProject_Group12/pages/notifications.php" class="btn btn-link" style="padding: 0;">Load More</a>
    </div>
    
    <!-- 📝 JavaScript to toggle the notifications dropdown -->
    <script>
        // Function to toggle the notifications dropdown visibility
        function toggleNotifications() {
            var notificationsDropdown = document.getElementById("notificationsDropdown");
            // Toggle dropdown visibility
            if (notificationsDropdown.style.display === "none" || notificationsDropdown.style.display === "") {
                notificationsDropdown.style.display = "block";
            } else {
                notificationsDropdown.style.display = "none";
            }
        }
    </script>
    
</body>
</html>