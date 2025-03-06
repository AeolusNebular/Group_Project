<!DOCTYPE html>
<html lang="en-gb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Smart Energy Dashboard</title>
</head>
<body>



<nav class="navbar" style="z-index: 2; background-color: #363b9e; width: 100%;">           
    <button style="float: left; margin-left: 15px" 
        class="navbar-toggler" 
        onclick="toggleNav()">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>


<nav id="main">
    <div class="sidebar" id="mySidebar">
        <ul style="list-style-type: none; width: 30px;">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">City</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Network</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Admin</a>
            </li>
        </ul>

        <button style='position: absolute; bottom: 0' type='Button' onclick="Login()">Login</button>
    </div>
</nav>



</body>
</html>