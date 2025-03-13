<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en-gb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Styles -->
    <link rel="stylesheet" href="/Group_Project/GroupProject_Group12/styles/style.css">
  
    
    <!-- chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="/Group_Project/GroupProject_Group12/scripts/sidebar.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/graph.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/darkmode.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/login_modal.js"></script>

    <title>Home - Smart Energy Dashboard</title>
    <link rel="stylesheet" href="/Group_Project/GroupProject_Group12/styles/style.css">
</head>
<body>



<nav class="navbar">           
    <button style="float: left; margin-left: 15px" 
        class="navbar-toggler" 
        onclick="toggleNav()">
        <span class="navbar-toggler-icon"></span>
    </button>

    <button onclick="toggledarklight()" class = "btn" style = "float: right; margin-right: 15px; background-color: transparent; "> 
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-stars-fill" viewBox="0 0 16 16">
            <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278"/>
            <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.73 1.73 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.73 1.73 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.73 1.73 0 0 0 1.097-1.097zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/>
        </svg>  
    </button>
</nav>


<nav id="main" style = "position: relative">
    <div class="sidebar" id="mySidebar"  >
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
                <a class="nav-link active" aria-current="page" href="/Group_Project/GroupProject_Group12/Pages/Personal_Information.php">Personal Info</a>
            </li>
        </ul>
        
        <div style="position: absolute; bottom: 50px; right: 15px;">
            <button  type='button' class = "btn btn-outline-light" style = "border-radius: 25px" onclick = "window.location.href = '/Group_Project/GroupProject_Group12/Pages/Login.php'">Login</button>
        </div>
    </div>
</nav>

</body>
</html>