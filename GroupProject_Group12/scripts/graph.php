<?php
    if (!isset($RoleID)) {
        return;
    }
    
    $RequestMethod      = $_SERVER['REQUEST_METHOD'];
    $Year               = $_REQUEST['Dashboard_Years']      ?? $_REQUEST['CityYears']       ?? $_GET['NetworkYearFilter']   ?? '2016';
    $Network            = $_REQUEST['Dashboard_Networks']   ?? $_REQUEST['CityNetworks']    ?? $RoleNetwork ?? $_GET['NetworkName']         ?? 'coteq';
    $Type               = $_GET['TypeFilter']                                                                               ?? 'Gas';

    $Types              = ['Gas', 'Electricity'];
    $Networks           = ['coteq', 'enexis', 'liander', 'stedin', 'westland-infra'];

    $DashboardNetwork   = $Network ;
    $CityName           = $CityFilter                                                                            ?? null;
    $CityFilter         = $_REQUEST['CityFilter']           ?? $_SESSION['City_Name']                                       ?? null;
    
    // Unified data containers
    $AllCSVCityData =               array_fill_keys($Types, []);
    $CityTypeValues =               array_fill_keys($Types, []);
    $AllCityDataForType =           array_fill_keys($Types, []);
    // 🌐 Network Totals
    $NetworkValueByType =           array_fill_keys($Types, []);
    $AllNetworkValueByType =        array_fill_keys($Types, []);
    // 🛡️ Admin Totals
    $AdminValueByType =             array_fill_keys($Types, []);
    $AllAdminNetworkValueByType =   array_fill_keys($Types, []);
    
    // 📊 DASHBOARD DATA BLOCK
    foreach ($Types as $TypeOfCSV) {
        if ($RoleID != 3) {
            $CityConsumeTotals = [];
            debug_to_console($Network);
            
            $Values = ($RoleID == 2)
                ? CSVData($TypeOfCSV, $Year, $Network)
                : CSVData($TypeOfCSV, $Year, $DashboardNetwork);
            
            foreach ($Values as $CityNameLoop => $City) {
                $CityConsumeTotals[$CityNameLoop] = ($CityConsumeTotals[$CityNameLoop] ?? 0) + $City[0];
            }
            
            $AllCSVCityData[$TypeOfCSV] += $CityConsumeTotals;
            
        } elseif ($RoleID == 3 && isset($CityFilter)) {
            $NetworkConsumeTotals = array_fill_keys($Networks, 0);
            
            foreach ($Networks as $Net) {
                $Values = FilterByCityCSV($TypeOfCSV, $Year, $Net, $CityFilter);
                foreach ($Values as $CityNameLoop => $CityData) {
                    $NetworkConsumeTotals[$Net] += $CityData[11];
                }
            }
            
            $AllCSVCityData[$TypeOfCSV] += $NetworkConsumeTotals;
        }
    }
    
    // 🏙️ CITY VIEW BLOCK
    foreach ($Types as $CType) {
        $CityAdditions = ['Annual' => 0, 'Connection' => 0, 'Delivery_Perc' => 0];
        $CityCount = 0; // Start at 0
        $CityValues = [];
        
        if ($CityName) {
            foreach ($Networks as $Net) {
                $CityCount = 1;
                $CityGraphValues = FilterByCityCSV($CType, $Year, $Net, $CityName);
                foreach ($CityGraphValues as $Key => $City) {
                    $CityValues[$Key] = $City[11];
                    $CityAdditions['Annual'] += $City[11];
                    $CityAdditions['Connection'] += $City[9];
                    $CityAdditions['Delivery_Perc'] += $City[7];
                }
            }
        } else {
            $CityGraphValues = CSVData($CType, $Year, $Network);
            foreach ($CityGraphValues as $Key => $City) {
                $CityCount++;
                $CityValues[$Key] = $City[0];
                $CityAdditions['Annual'] += $City[0];
                $CityAdditions['Connection'] += $City[1];
                $CityAdditions['Delivery_Perc'] += $City[2] / 100;
            }
        }
        
        $CityAdditions['Delivery_Perc'] /= $CityCount;
        $AllCityDataForType[$CType]     = $CityAdditions;
        $CityTypeValues[$CType]         = $CityValues;
    }
    
    // 🛡️ ADMIN VIEW BLOCK
    $AYear  = $_GET['Admin_Network_Year'] ?? '2016';
    $AdType = $_GET['Admin_Network_Type'] ?? 'Electricity';
    
    $AllAdminCityAnnualTypes    = array_fill_keys($Types, []);
    $AllAdminCityValueTypes     = array_fill_keys($Types, []);
    
    foreach ($Types as $AType) {
        
        $NetworkConsumeTotals   = array_fill_keys($Networks, 0);
        $NetworkAdminTotals     = ['Annual' => 0, 'Connection' => 0, 'Delivery_Perc' => 0];
        
        foreach ($Networks as $ANetwork) {
            $Values = CSVData($AType, $AYear, $ANetwork);
            foreach ($Values as $Value) {
                $NetworkConsumeTotals[$ANetwork] += $Value[0];
                $NetworkAdminTotals['Annual'] += $Value[0];
                $NetworkAdminTotals['Connection'] += $Value[1];
                $NetworkAdminTotals['Delivery_Perc'] += $Value[2];
            }
        }
        $AllAdminNetworkValueByType[$AType] = $NetworkAdminTotals;
        $AdminValueByType[$AType]           = $NetworkConsumeTotals;
    }

    // 🛡️ 2nd ADMIN CHART BLOCK
    $CityYear       = $_GET['AdminNetworkYear'] ?? '2016';
    $ACityFilter     = $_GET['Admin_City_Type']  ?? 'Electricity';
    $CityNetwork    = $_GET['AdminNetwork']     ?? 'coteq';
 
    foreach ($Types as $CityType) {
        $CityValues = [];
        $AllCityValuesAdmin = ['Annual' => 0, 'Connection' => 0, 'Delivery_Perc' => 0];
        $CityGraphValues = CSVData($CityType, $CityYear, $CityNetwork);

        foreach ($CityGraphValues as $Key => $City) {
            $CityValues[$Key] = $City[0];
            $AllCityValuesAdmin['Annual'] += $City[0];
            $AllCityValuesAdmin['Connection'] += $City[1];
            $AllCityValuesAdmin['Delivery_Perc'] += $City[2];
        }
        $AllAdminCityAnnualTypes[$CityType] = $CityValues;
        $AllAdminCityValueTypes[$CityType]  = $AllCityValuesAdmin;
    }

    
    // 🟢 Output data for JavaScript use
    if (isset($AdminValueByType[$AdType])) {
        echo "<script>const networkGraphData = " . json_encode($AdminValueByType[$AdType]) . ";</script>";
    }
    
    // 🌐 NETWORK FILTER BLOCK
    foreach ($Types as $NType) {
        $NetworkValue = CSVData($NType, $Year, $Network);
        $TotalNetworkConsume = [];
        $NetworkAdditions = ['Annual' => 0, 'Connection' => 0, 'Delivery_Perc' => 0];
        
        foreach ($NetworkValue as $City => $Data) {
            $TotalNetworkConsume[$City] = ($TotalNetworkConsume[$City] ?? 0) + $Data[0];
            $NetworkAdditions['Annual'] += $Data[0];
            $NetworkAdditions['Connection'] += $Data[1];
            $NetworkAdditions['Delivery_Perc'] += $Data[2]/100;
            
        }
        $AllNetworkValueByType[$NType]  = $NetworkAdditions;
        $NetworkValueByType[$NType]     = $TotalNetworkConsume;
    }
    
?>

<script>
    // 📦 Shared variables
    const sharedColours = [
        '#003f5c', '#374c80', '#58508d', '#7a5195', '#bc5090', '#ff6361', '#ffa600'
    ];
    const font = { family: "Space Grotesk" };
    
    // 🏗️ Create chart variables
    let chartDashboard = null;
    let chartCity = null;
    let chartCityNetwork = null;
    let chartLine = null;
    let chartAdminDoughnut = null;
    let chartAdminBar = null;
    let URI = null;
    
    // 📊 PHP-injected data
    const DashboardData = <?php echo json_encode($AllCSVCityData); ?>;
    const CityData = <?php echo json_encode($CityTypeValues['Electricity']); ?>;
    const AdminCityData = <?php echo json_encode($AllAdminCityAnnualTypes[$ACityFilter]);?>;
    const NetworkData = <?php echo json_encode($NetworkValueByType[$Type]); ?>;
    
    // 🎨 Utility: get text colour based on theme
    function getTextColor() {
        console.log("Fetching text colours.");
        const storedThemeMode = sessionStorage.getItem("themeMode") || "purple-light";
        const [_, storedMode] = storedThemeMode.split("-");
        const root = document.body;
        
        const light = getComputedStyle(root).getPropertyValue("--text-light").trim();
        const dark = getComputedStyle(root).getPropertyValue("--text-dark").trim();
        
        console.log("Light:", light);
        console.log("Dark:", dark);
        console.log("Fetched text colours.");
        
        return storedMode === "light" ? light : dark;
    }
    
    // <---------------------------------------- 📊 CHARTS ---------------------------------------->
    
    // 📊 Dashboard mixed chart [dashboard - home page]
    function drawDashboardGraph() {
        const canvas = document.getElementById("dashboardCanvas");
        
        // ✅ Ensure the canvas context is fresh
        if (!canvas) return; // 👋 Exit if canvas is missing
        const ctx = canvas.getContext("2d");
        
        console.log("▶️ Dashboard chart triggered.")
        
        // 💥 Destroy existing chart properly
        if (chartDashboard) {
            chartDashboard.destroy();
            chartDashboard = null; // 🧹 Clear instance reference
        }
        
        chartDashboard = new Chart(ctx, {
            data: {
                labels: Object.keys(DashboardData['Electricity']),
                datasets: [{
                    type: 'pie',
                    label: 'Gas',
                    data: Object.values(DashboardData['Gas']),
                    backgroundColor: sharedColours,
                    borderColor: "#00000000",
                    hoverOffset: 10
                }, {
                    type: 'bar',
                    label: 'Electricity',
                    data: Object.values(DashboardData['Electricity']),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgb(75, 192, 192)', // ‼️ Better using brighter outlined bars to differentiate from stacked pie chart
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: {
                            color: getTextColor(),
                            font: font
                        }
                    },
                    title: {
                        display: true,
                        text: "Networks Annual Usage",
                        color: getTextColor(),
                        font: font
                    }
                }
            }
        });
        console.log("✅ Dashboard chart loaded.")
    }
    
    // 🏙️ City electricity bar chart [city page]
    function drawBarGraph() {
        const canvas = document.getElementById("cityCanvas");
        
        // ✅ Ensure the canvas context is fresh
        if (!canvas) return; // 👋 Exit if canvas is missing
        const ctx = canvas.getContext("2d");
        
        console.log("▶️ City chart triggered.")
        
        // 💥 Destroy existing chart properly
        if (chartCity) {
            chartCity.destroy();
            chartCity = null; // 🧹 Clear instance reference
        }
        
        chartCity = new Chart(ctx, {
            type: "bar",
            data: {
                labels: Object.keys(CityData),
                datasets: [{
                    label: "Electricity",
                    data: Object.values(CityData),
                    backgroundColor: sharedColours,
                }]
            },
            options: {
                animation: {
                    duration: 700,
                    easing: 'easeOutQuad',
                    onComplete: function () {
                        URI = chartCity.toBase64Image("image/jpeg", 1);
                        const imageField = document.getElementById('ImageURLForPDF');
                        if (imageField) imageField.value = URI;
                       
                    }
                },
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: {
                            color: getTextColor(),
                            font: font
                        }
                    },
                    title: {
                        display: true,
                        text: "Networks Annual Usage",
                        color: getTextColor(),
                        font: font
                    }
                }
            }
        });
        console.log("✅ City chart loaded.")
    }
    
    // 🏙️ Big city electricity bar chart [network page]
    function drawNetworkCityChart() {
        const canvas = document.getElementById("cityCanvasNetwork");
        console.log(NetworkData);
        
        // ✅ Ensure the canvas context is fresh
        if (!canvas) return; // 👋 Exit if canvas is missing
        const ctx = canvas.getContext("2d");
        
        console.log("▶️ City chart triggered.")
        
        // 💥 Destroy existing chart properly
        if (chartCityNetwork) {
            chartCityNetwork.destroy();
            chartCityNetwork = null; // 🧹 Clear instance reference
        }
        
        chartCityNetwork = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(NetworkData),
                datasets: [{
                    label: 'City Data',
                    data: Object.values(NetworkData),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgb(75, 192, 192)', // ‼️ Better using brighter outlined bars due to being thinner
                    borderWidth: 1
                }]
            },
            options: {
                animation: {
                    duration: 700,
                    easing: 'easeOutQuad',
                    onComplete: function () {
                        URI = chartCityNetwork.toBase64Image("image/jpeg", 1);
                        const imageField = document.getElementById('ImageURLForPDF');
                        if (imageField) imageField.value = URI;
                    }
                },
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: {
                            color: getTextColor(),
                            font: font
                        }
                    },
                    title: {
                        display: true,
                        text: "Cities by Network",
                        color: getTextColor(),
                        font: font
                    }
                }
            }
        });
        console.log("✅ Network chart loaded.")
    }
    
    // 📈 Line Chart (Test Chart)
    function drawLineChart() {
        const canvas = document.getElementById("testChart");
        
        // ✅ Ensure the canvas context is fresh
        if (!canvas) return; // 👋 Exit if canvas is missing
        const ctx = canvas.getContext("2d");
        
        console.log("▶️ Line chart triggered.")
        
        // 💥 Destroy existing chart properly
        if (chartLine) {
            chartLine.destroy();
            chartLine = null; // 🧹 Clear instance reference
        }
        
        // ✅ Create chart
        chartLine = new Chart(ctx, {
            type: "line",
            data: {
                labels: ["2017", "2018", "2019", "2020", "2021", "2022", "2023"],
                datasets: [{
                    label: "Energy Usage (kWh)",
                    data: [564, 585, 649, 1170, 990, 760, 830],
                    borderColor: "rgba(150, 90, 225, 1)",
                    backgroundColor: "rgba(150, 90, 225, 0.3)",
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: {
                            color: getTextColor(),
                            font: font
                        }
                    },
                    title: {
                        display: true,
                        text: "Energy Usage Over Time",
                        color: getTextColor(),
                        font: font
                    }
                }
            }
        });
        console.log("✅ Line chart loaded.")
    }
    
    // 🍩 Network doughnut chart [admin page]
    function drawNetworkDoughnut() {
        const canvas = document.getElementById("networkCanvas");
        
        // ✅ Ensure the canvas context is fresh
        if (!canvas) return; // 👋 Exit if canvas is missing
        const ctx = canvas.getContext("2d");
        
        console.log("▶️ Admin doughnut chart triggered.")
        
        // 💥 Destroy existing chart properly
        if (chartAdminDoughnut) {
            chartAdminDoughnut.destroy();
            chartAdminDoughnut = null; // 🧹 Clear instance reference
        }
        
        // ✅ Create chart
        chartAdminDoughnut = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: ["Coteq", "Stedin", "Liander", "Westlandinfra", "Enexis"],
                datasets: [{
                    label: "Network Usage",
                    data: Object.values(networkGraphData),
                    backgroundColor: sharedColours,
                    borderColor: "#00000000",
                    zIndex: 1,
                    hoverOffset: 10
                }],
            },
            options: {
                animation: {
                    duration: 700,
                    easing: 'easeOutQuad',
                    onComplete: function () {
                        URI = chartAdminDoughnut.toBase64Image("image/jpeg", 1);
                        const imageField = document.getElementById('ImageURLForPDFN');
                        if (imageField) imageField.value = URI;
                        
                    }
                },
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: {
                            color: getTextColor(),
                            font: font
                        },
                    },
                    title: {
                        display: true,
                        text: "Networks Annual Usage",
                        color: getTextColor(),
                        font: font
                    },
                },
            },
        });
        console.log("✅ Admin doughnut chart loaded.")
    }
    
    // 🏙️ City councils bar chart [admin page]
    function drawAdminBarGraph() {
        const citycanvas = document.getElementById("AdminCityCouncilCanvas");
        
        // ✅ Ensure the canvas context is fresh
        if (!citycanvas) return; // 👋 Exit if canvas is missing
        const ctx = citycanvas.getContext("2d");
        
        console.log("▶️ Admin bar chart triggered.")
        
        // 💥 Destroy existing chart properly
        if (chartAdminBar) {
            chartAdminBar.destroy();
            chartAdminBar = null; // 🧹 Clear instance reference
        }
        
        chartAdminBar = new Chart(ctx, {
            type: "bar",
            data: {
                labels: Object.keys(AdminCityData),
                datasets: [{
                    label: <?php echo json_encode($CityType); ?>,
                    data: Object.values(AdminCityData),
                    backgroundColor: sharedColours,
                    borderColor: "#00000000",
                }]
            },
            options: {
                animation: {
                    duration: 700,
                    easing: 'easeOutQuad',
                    onComplete: function () {
                        URI = chartAdminBar.toBase64Image("image/jpeg", 1);
                        const imageField = document.getElementById('ImageURLForPDF');
                        if (imageField) imageField.value = URI;
                     
                    }
                },
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: {
                            color: getTextColor(),
                            font: font
                        },
                    },
                    title: {
                        display: true,
                        text: "Networks Annual Usage",
                        color: getTextColor(),
                        font: font
                    }
                },
            }
        });
        console.log("✅ Admin bar chart loaded.")
    }
    
    function filterData() {
        console.log("▶️ Data filter triggered.")
        const selectedCity = document.getElementById('cityFilter').value;
        
        // Check if the selected city exists in the data, then update the chart
        if (data[selectedCity]) {
            chartCityNetwork.data.datasets[0].data = data[selectedCity];
            chartCityNetwork.update();
            console.log("✅ Data filter completed.")
        } else {
            console.error("Selected city data not found.");
        }
    }
    
    // 🚀 Initialise all charts on DOM load
    document.addEventListener("DOMContentLoaded", function () {
        drawDashboardGraph();
        drawBarGraph();
        drawLineChart();
        drawNetworkCityChart();
        drawNetworkDoughnut();
        drawAdminBarGraph();
    });
    
    // 📏 Resize handler (debounced)
    let resizeTimeout;
    window.addEventListener("resize", () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            drawDashboardGraph();
            drawBarGraph();
            drawLineChart();
            drawNetworkCityChart();
            drawNetworkDoughnut();
            drawAdminBarGraph();
        }, 250);
    });
    
    // 🔁 Redraw active chart(s) on theme change
    function redrawAllCharts() {
        drawDashboardGraph();
        drawBarGraph();
        drawLineChart();
        drawNetworkCityChart();
        drawNetworkDoughnut();
        drawAdminBarGraph();
    }
    
    /*
    document.addEventListener("DOMContentLoaded", function () {
        drawCouncilChart();
        window.addEventListener("resize", drawCouncilChart); // ✅ Attach resize event once
    });
    
    Create chart
    function drawCouncilChart() {
        let isDarkMode = document.body.classList.contains("dark-mode");
        
        // 🎨 Retrieve the current mode (light or dark) from sessionStorage for text colour
        const storedThemeMode = sessionStorage.getItem("themeMode")
        const [storedTheme, storedMode] = storedThemeMode.split("-");
        let textColor = storedMode === "light" ? "#000" : "#fff";
        
        const canvas = document.getElementById("AdminCityCoucilCanvas");
        
        // ✅ Ensure the canvas context is fresh
        if (!canvas) return; // 👋 Exit if canvas is missing
        const ctx = canvas.getContext("2d");
        
        // 💥 Destroy existing chart properly
        if (chartInstance) {
            chartInstance.destroy();
            chartInstance = null; // 🧹 Clear instance reference
        }
        
        chartInstance = new Chart(ctx, {
            type: "scatter",
            data: {
                labels: ["2017","2018","2019","2020", "2021", "2022", "2023"],
                datasets: [{
                    label: "Energy Usage (kWh)",
                    data: [564, 585, 649, 1170, 990, 760, 830],
                    borderColor: "rgba(150, 90, 225, 1)",
                    backgroundColor: "rgba(150, 90, 225, 1)",
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: { color: textColor }
                    },
                    title: {
                        display: true,
                        text: "Energy Usage Over Time",
                        color: textColor
                    }
                },
                scales: {
                    x: {
                        ticks: { color: textColor },
                        grid: { color: lineColor }
                    },
                    y: {
                        ticks: { color: textColor },
                        grid: { color: lineColor }
                    }
                }
            }
        });
    }
    */
</script>