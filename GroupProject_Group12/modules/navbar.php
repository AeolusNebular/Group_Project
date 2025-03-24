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
                <button onclick="toggleDarkLight()" id="darkModeToggle" class="btn" 
                    style="margin-right: 8px;" 
                    aria-label="Toggle Dark Mode"> 
                    <svg id="darkModeIcon" xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" class="bi bi-moon-stars-fill" viewBox="0 0 16 16">
                        <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278"/>
                    </svg>
                </button>
            </div>

            <div class="icon-container">
                <!-- 📍 Notifications Icon -->
                <button id="notificationsButton" class="btn" onclick="toggleNotifications()" aria-label="Notifications" style="color: white;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                        <path d="M8 16a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm6-6V7a6 6 0 0 0-12 0v3c0 .839-.472 1.574-1.14 1.962-.688.396-1.514.626-2.36.656v.348a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-.348c-.846-.03-1.672-.26-2.36-.656-.668-.388-1.14-1.123-1.14-1.962z"/>
                    </svg>
                </button>

                <!-- 👤 Account button with dropdown -->
                <div class="account-menu">
                    <button id="accountButton" class="account-btn" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26px" height="26px" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 8a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM1 14s1-4 7-4 7 4 7 4H1z"/>
                        </svg>
                    </button>

                    <!-- Dropdown -->
                    <div id="accountDropdown" class="dropdown">
                        <a href="/Group_Project/GroupProject_Group12/pages/account.php">Profile</a>
                        <a href="/Group_Project/GroupProject_Group12/pages/settings.php">Settings</a>
                        <a href="/Group_Project/GroupProject_Group12/pages/account.php">Logout</a>
                    </div>
                </div>
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
        <!-- Button to load more notifications -->
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
