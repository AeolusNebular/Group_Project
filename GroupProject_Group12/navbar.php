<!DOCTYPE html>
<html lang="en-gb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/theme-toggles@4.10.1/css/classic.min.css">
    <link rel="stylesheet" href="/Group_Project/GroupProject_Group12/style.css">
    <link rel="stylesheet" href="/Group_Project/GroupProject_Group12/login.css">
    
    <!-- chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="/Group_Project/GroupProject_Group12/scripts/sidebar.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/graph.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/darkmode.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/login_modal.js"></script>

    <title>Home - Smart Energy Dashboard</title>
    <link rel="stylesheet" href="/Group_Project/GroupProject_Group12/style.css">
</head>
<body>



<nav class="navbar">           
    <button class="fa fa-bars" style="float: left; margin-left: 15px" 
        class="navbar-toggler" 
        onclick="toggleNav()">
        <span class=""></span>
    </button>

    <button onclick="toggledarklight()" class = "btn theme-toggle theme-toggle--toggled theme-toggle--force-motion" style = "float: right; margin-right: 15px; background-color: transparent; "> 
    <svg
    xmlns="http://www.w3.org/2000/svg"
    aria-hidden="true"
    width="1em"
    height="1em"
    fill="currentColor"
    stroke-linecap="round"
    class="theme-toggle__classic"
    viewBox="0 0 32 32"
  >
    <clipPath id="theme-toggle__classic__cutout">
      <path d="M0-5h30a1 1 0 0 0 9 13v24H0Z" />
    </clipPath>
    <g clip-path="url(#theme-toggle__classic__cutout)">
      <circle cx="16" cy="16" r="9.34" />
      <g stroke="currentColor" stroke-width="1.5">
        <path d="M16 5.5v-4" />
        <path d="M16 30.5v-4" />
        <path d="M1.5 16h4" />
        <path d="M26.5 16h4" />
        <path d="m23.4 8.6 2.8-2.8" />
        <path d="m5.7 26.3 2.9-2.9" />
        <path d="m5.8 5.8 2.8 2.8" />
        <path d="m23.4 23.4 2.9 2.9" />
      </g>
    </g>
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
        </ul>
        
        <div style="position: absolute; bottom: 50px; right: 15px;">
            <button  type='button' class = "btn btn-outline-light" style = "border-radius: 25px" onclick = "window.location.href = '/Group_Project/GroupProject_Group12/Pages/Login.php'">Login</button>
        </div>
    </div>
</nav>

</body>
</html>