<!DOCTYPE html>
<html lang="en-gb">
<head>
    <!-- 📢 Header -->
    <?php include_once "../modules/header.php"; ?>
    
    <title> Account - Smart Energy Dashboard </title>
</head>

<body>
    
    <!-- 📍 Navbar and login -->
    <?php 
        include("../modules/navbar.php");
        include("../modules/login.php");
        require_once('../Database_Php_Interactions/Database_Utilities.php');
        include('../Database_Php_Interactions/CSVData.php');
        debug_to_console($UserID);
    ?>
    
    <!-- 👤 Account page content -->
    <div class="container mt-4">
        
        <!-- 📛 Title -->
        <div class="text-center">
            <h2> Account </h2>
        </div>
        
        <div class="row gx-1">
            <!-- 📝 User summary panel (fat) -->
            <div class="col-12 col-md-8 d-flex">
                <div class="card">
                    <div class="card-header"> 👤 User Summary </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <!-- 👤 Profile -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 8a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM1 14s1-4 7-4 7 4 7 4H1z"/>
                            </svg>
                            <div class="ms-3">
                                <h5 class="mb-0">
                                    <?php echo isset($UserFName) ? $UserFName : 'Bob'; ?>
                                    <?php echo isset($UserSName) ? $UserSName : 'Smith'; ?>
                                </h5>
                                <small>
                                    <?php echo isset($UserEmail) ? $UserEmail : 'bobsmith@boibsmith.com';?>
                                </small>
                            </div>
                        </div>
                        
                        <!-- 👤 User summary -->
                        <div>
                            <hr>
                            <p>
                                <b> Phone number: </b>
                                <?php
                                    function formatPhoneNumber($number) {
                                        // ✅ Check if number has at least 10 digits
                                        if (strlen($number) === 10) {
                                            return preg_replace('/(\d{4})(\d{6})/', '$1 $2', $number);
                                        } elseif (strlen($number) === 11) {
                                            return preg_replace('/(\d{5})(\d{6})/', '$1 $2', $number);
                                        } elseif (strlen($number) === 12) {
                                            return preg_replace('/(\d{2})(\d{4})(\d{6})/', '+$1 $2 $3', $number);
                                        } else {
                                            return $number; // Return unformatted if it doesn't fit
                                        }
                                    }
                                    
                                    echo isset($UserPhoneNo) ? formatPhoneNumber($UserPhoneNo) : '+44 #### ######';
                                ?>
                            </p>
                            <p>
                                <b> Address: </b>
                                <?php echo isset($UserHouseNo) ? $UserHouseNo : '123 Demo Street' ?>
                            </p>
                            <p>
                                <b> Role: </b>
                                <?php 
                                    switch ($RoleID) {
                                        case 3 : {
                                            echo 'City council user for ' . $CityFilter;
                                            break;
                                        }
                                        case 2 : {
                                            echo 'Network user with ' . $RoleNetwork;
                                            break;
                                        }
                                        case 1 : {
                                            echo 'Admin user';
                                            break;
                                        }
                                    }
                                ?>
                            </p>
                            <hr>
                        </div>
                        
                        <!-- 🏃‍♂️ Account action buttons -->
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-danger"> 🗑️ Delete Account </button>
                            <button class="btn btn-warning"> 🔄 Reset Password </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- ➕ Side panel (thin) -->
            <div class="col-12 col-md-4 d-flex">
                <div class="card">
                    <div class="card-header"> ➕ Additional User Information </div>
                    <div class="card-body">
                        <form action='../Database_Php_Interactions/UpdateUserInfo.php' method='POST'>
                            
                            <div class="mb-2">
                                <label for="UserFName" class="form-label"> First name: </label>
                                <input type="text" id="UserFName" name="UserFName" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label for="UserLName" class="form-label"> Last name: </label>
                                <input type="text" id="UserLName" name="UserLName" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label for="UserPhoneNo" class="form-label"> Phone number: </label>
                                <input type="tel" id="UserPhoneNo" name="UserPhoneNo" class="form-control" required>
                            </div> 
                            <input type="hidden" id='UserID' value=<?php $UserID ?>>
                            <div class="mb-2">
                                <label for="UserHomeNo" class="form-label"> Home address: </label>
                                <input type="text" id="UserHomeNo" name="UserHomeNo" class="form-control" required>
                            </div>
                            <button type="submit" style='float: right' class="fancy-button">
                                Update User Info
                            </button>
                            
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
                <h2> Settings </h2>
            </div>
            
            <!-- ⚙️ Side panel (half-width) -->
            <div class="col-12 col-md-6 d-flex">
                <!-- 🎨 Customisability options -->
                <div class="card">
                    <div class="card-header"> 🎨 Theme Settings </div>
                    <div class="card-body">
                        <ul>
                            <li>
                                <!-- 🌙 Manual dark/light mode controls -->
                                <label for="darkMode"> Dark/light mode: </label>
                                <div class="themed-dropdown">
                                    <select class="form-select" id="darkMode">
                                        <option value="auto">  Device </option>
                                        <option value="dark">  Dark </option>
                                        <option value="light"> Light </option>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <input type="checkbox" id="darkModeNavbar" class="form-check-input" checked>
                                <label for="darkModeNavbar"> Show dark mode toggle in navbar </label>
                            </li>
                            <br>
                            <li>
                                <!-- 🎨 Theme selection menu -->
                                <label for="theme">Theme selection:</label>
                                <div class="themed-dropdown">
                                    <select class="form-select" onchange="CheckTheme(this.value)" id="theme">
                                        <option value="purple" class="purple-option"> 🟪 Purple (default) </option>
                                        <option value="green"  class="green-option">  🟩 Green </option>
                                        <option value="marine" class="marine-option"> 🌊 Marine </option>
                                        <option value="blue"   class="blue-option">   🟦 Blue </option>
                                        <option value="red"    class="red-option">    🟥 Red </option>
                                        <option value="sigma"  class="sigma-option">  🐺 Sigma </option>
                                        <option value="matrix" class="matrix-option"> 💻 Matrix </option>
                                        <option value="sunset" class="sunset-option"> 🌇 Sunset </option>
                                        <option value="desert" class="desert-option"> 🏜️ Desert </option>
                                        <option value="cosmic" class="cosmic-option"> 🌌 Cosmic </option>
                                        <option value="bling"  class="bling-option">  💰 Bling </option>
                                        <!-- <option value="bonus"  class="bonus-option">  🌈 Bonus </option> -->
                                        <option value="root"   class="root-option">   ⚙️ Root </option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- ⚙️ Side panel (half-width) -->
            <div class="col-12 col-md-6 d-flex">
                <!-- 🎨 Accessibility options -->
                <div class="card">
                    <div class="card-header"> ⚙️ Accessibility Settings </div>
                    <div class="card-body">
                        <ul>
                            
                            <!-- 🔤 Font options -->
                            <li>
                                <label for="fontSize"> Font size: </label>
                                <div class="themed-dropdown">
                                    <select id="fontSize" class="form-select">
                                        <option value="default">     Default </option>
                                        <option value="large">       Large </option>
                                        <option value="extra-large"> Extra large </option>
                                    </select>
                                </div>
                            </li>
                            
                            <!-- 🌓 High contrast mode -->
                            <li>
                                <input type="checkbox" id="highContrast" class="form-check-input">
                                <label for="highContrast"> High contrast </label>
                            </li>
                            
                            <!-- 🎞️ Limit animations -->
                            <li>
                                <input type="checkbox" id="limitAnimations" class="form-check-input">
                                <label for="limitAnimations"> Limit screen animations </label>
                            </li>
                            
                            <!-- 🌈 Colourblind options -->
                            <li>
                                <label for="colourblind"> Colour blindness: </label>
                                <div class="themed-dropdown">
                                    <select id="colourblind" class="form-select">
                                        <option value="default">       None </option>
                                        <option value="deuteranopia">  Deuteranopia </option>
                                        <option value="tritanopia">    Tritanopia </option>
                                        <option value="achromatopsia"> Achromatopsia </option>
                                    </select>
                                </div>
                            </li>
                            
                            <!-- 🌈 Colourblind filters -->
                            <?php include("../modules/colourblind-filters.php"); ?>
                        </ul>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <!-- 👣 Footer -->
    <?php include("../modules/footer.php"); ?>
    
</body>
</html>
