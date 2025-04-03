<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['UserID'])) {
    echo'
        <!-- 🔲 Overlay -->
        <div class="overlay"></div>

        <!-- ⚠️ Alert Box -->
        <div class="alert alert-info" role="alert">
            ⚠️ Please login to view this page!
        </div>';
} else {
    if (isset($_SESSION['RoleID'])) {
        $RoleID = $_SESSION['RoleID'];
    } else {
        $RoleID = null;
    }
    $UserID = $_SESSION['UserID'];
    $UserEmail = $_SESSION['Email'];
    
    if (!is_null($_SESSION['FName'])) {
        $UserFName = $_SESSION['FName'];
    }
    if (!is_null($_SESSION['SName'])) {
        $UserSName = $_SESSION['SName'];
    }
    if (!is_null($_SESSION['PhoneNo'])) {
        $UserPhoneNo = $_SESSION['PhoneNo'];
    }
    if (!is_null($_SESSION['HouseNo'])) {
        $UserHouseNo = $_SESSION['HouseNo'];
    }
    if (!is_null($_SESSION['StreetName'])) {
        $UserStreetName = $_SESSION['StreetName'];
    }
    if ($RoleID == '2') {
        $RoleNetwork = $_SESSION['Network_Name'];
    } elseif ($RoleID == '3') {
        $CityFilter = $_SESSION['City_Name'];
    }
}

$conn = new SQLite3("../database/users.db");
if (!$conn) {
    die('Connection failed: ' . $conn->lastErrorMsg());
}

// 📨 Fetch the most recent 5 notifications
$notifStmt = $conn->prepare("SELECT NotifID, Notification FROM Notifications ORDER BY NotifID DESC LIMIT 5");
$notifResult = $notifStmt->execute();

if (!$notifResult) {
    die('Query failed: ' . $conn->lastErrorMsg());
}
?>

<!DOCTYPE html>
<html lang="en-gb">

<body>
    <!-- 📍 Navbar content -->
    <nav class="navbar">
        
        <!-- 🔀 Sidebar toggle -->
        <button class="navbar-toggler
            <?php echo isset($_SESSION['RoleID']) ? '' : 'invisible'; ?>" 
            type="button" onclick="toggleNav()" 
            aria-label="Toggle navigation" aria-controls="mySidebar">
            <span class="navbar-toggle-icon"></span>
        </button>
        
        <!-- 📛 Title -->
        <h2>Smart Energy Dashboard</h2>
        
        <div>
            <div class="icon-container">
                <!-- 🌙 Dark mode toggler (icon set by JS) -->
                <button onclick="updateDarkMode()" id="darkModeToggle" class="btn" style="margin-right: 8px;" aria-label="Toggle dark mode"> 
                    <svg id="darkModeIcon" width="24px" height="24px" viewBox="0 0 16 16"></svg>
                </button>
            </div>
            
            <!-- 🔔 Notifications button with dropdown -->
            <?php if (isset($_SESSION['RoleID'])): ?>
                <div class="icon-container">
                    <button id="notificationsButton" class="btn" onclick="toggleNotifications()" aria-label="Open notifications dropdown" style="color: white;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" class="bell-icon" viewBox="0 1 16 17">
                            <path d="M8 2C5.5 2 3.5 4.5 3.5 7v3c0 .8-.5 1.5-1.2 2h11.4c-.7-.5-1.2-1.2-1.2-2V7c0-2.5-2-5-4.5-5z"/>
                            <path d="M2.5 12c-.8 0-1.5.7-1.5 1.5S1.7 15 2.5 15h11c.8 0 1.5-.7 1.5-1.5S14.3 12 13.5 12h-11z"/>
                            <circle cx="8" cy="15" r="2"/>
                        </svg>
                    </button>
                    
                    <!-- 🔽 Dropdown notifications -->
                    <div id="notificationsDropdown" class="dropdown-menu">
                        <div id="notificationList" class="notification-list">
                            <?php
                            // 🔄 Loop through the results and display each notification
                            while ($notif = $notifResult->fetchArray(SQLITE3_ASSOC)) {
                                echo '<a href="/Group_Project/GroupProject_Group12/pages/notifications.php" class="notification-item">';
                                echo '<p>' . htmlspecialchars($notif['Notification']) . '</p>'; // Display notification
                                echo '</a>';
                            }
                            ?>
                        </div>
                        <!-- ➕ Plus icon to show all -->
                        <a href="/Group_Project/GroupProject_Group12/pages/notifications.php" class="btn btn-link" style="padding: 0; display: flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 5v14M5 12h14" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- 👤 Account button with dropdown -->
            <div class="account-menu">
                
                <?php 
                    if (isset($UserID)) {
                        echo '
                        <button id="accountButton" class="account-btn" aria-haspopup="true" aria-expanded="false" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="26px" height="26px" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 8a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM1 14s1-4 7-4 7 4 7 4H1z"/>
                            </svg>
                        </button>';
                    } else {
                        echo'
                        <button type="button" class="fancy-button" data-bs-toggle="modal" data-bs-target="#LoginModal" aria-label="Login" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="26px" height="26px" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 8a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM1 14s1-4 7-4 7 4 7 4H1z"/>
                            </svg> Login 
                        </button>';
                    }
                    
                    // 🔽 Dropdown menu
                    if (isset($UserID)) {
                        echo '
                        <div id="accountDropdown" class="dropdown">
                        <a href="/Group_Project/GroupProject_Group12/pages/account.php">Profile</a>
                        <a href="/Group_Project/GroupProject_Group12/pages/account.php">Settings</a>
                        <a href="/Group_Project/GroupProject_Group12/Database_Php_Interactions/logout.php">Logout</a>
                        </div>';
                    }
                ?>
            </div>
            
        </div>
    </nav>
    
    <script>
        function toggleNotifications() {
            var notificationsDropdown = document.getElementById("notificationsDropdown");
            console.log("Toggling notifications dropdown...");
            if (notificationsDropdown.style.display === "none" || notificationsDropdown.style.display === "") {
                notificationsDropdown.style.display = "block";
            } else {
                notificationsDropdown.style.display = "none";
            }
        }
    </script>
    
    <!-- 🔀 Sidebar -->
    <nav id="main">
        <div class="sidebar" id="mySidebar">
            <ul style="list-style-type: none;">
                
                <!-- 🛸 Spacer -->
                <div>
                    <br>
                </div>
                
                <!-- 🏠 Dashboard (home page) -->
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/Group_Project/GroupProject_Group12/pages/home.php">Dashboard</a>
                </li>
                
                <?php 
                if (isset($RoleID)) {
                    if ($RoleID <= 3) {
                        echo 
                        ' <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/Group_Project/GroupProject_Group12/pages/city.php">City</a>
                        </li> ';
                    } 
                    if ($RoleID <= 2) {
                        echo 
                        '<li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/Group_Project/GroupProject_Group12/pages/network.php">Network</a>
                        </li> ';
                    } 
                    if ($RoleID == 1) {
                        echo '
                        <li class="nav-item">
                        <br>
                        <a class="nav-link active" aria-current="page" href="/Group_Project/GroupProject_Group12/pages/admin.php">Admin</a>
                        </li> ';
                    }
                }
                ?>
                
                <!-- 🛸 Spacer -->
                <div>
                    <br>
                    <br>
                    <br>
                    <br>
                </div>
                
                <!-- 👤 Account page (direct link for redundancy) -->
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/Group_Project/GroupProject_Group12/pages/account.php">Account</a>
                </li>
                
                <!-- 🔔 Notifications page (direct link for redundancy) -->
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/Group_Project/GroupProject_Group12/pages/notifications.php">Notifications</a>
                </li>
                
            </ul>
        </div>
    </nav>
    
    <!-- ⚠️ Error Popup Modal -->
    <div class="modal fade" id="ErrorModal" tabindex="-1" aria-labelledby="ErrorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="ErrorModalLabel">Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="ErrorModalMessage">
                    <!-- ⚠️ Error message dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>