<?php
    if (!isset($RoleID)) return;
    
    $RequestMethod = $_SERVER['REQUEST_METHOD'];
    $Year = $_REQUEST['Dashboard_Years'] ?? $_REQUEST['CityYears'] ?? $_POST['NetworkYearFilter'] ?? '2016';
    $Network = $_REQUEST['Dashboard_Networks'] ?? $_REQUEST['CityNetworks'] ?? $_POST['NetworkName'] ?? 'coteq';
    $Type = $_POST['TypeFilter'] ?? 'Gas';
    $Types = ['Gas', 'Electricity'];
    $DashboardNetwork = $Network;
    $CityName = $_SESSION['City_Name'] ?? null;
    
    // Unified data containers
    $AllCSVCityData = ['Gas' => [], 'Electricity' => []];
    $CityTypeValues = ['Gas' => [], 'Electricity' => []];
    $AllCityDataForType = ['Gas' => [], 'Electricity' => []];
    $NetworkValueByType = ['Gas' => [], 'Electricity' => []];
    
    // 📊 DASHBOARD DATA BLOCK
    foreach ($Types as $TypeOfCSV) {
        if ($RoleID != 3) {
            $CityConsumeTotals = [];
            
            $Values = ($RoleID == 2)
                ? CSVData($TypeOfCSV, $Year, $RoleNetwork)
                : CSVData($TypeOfCSV, $Year, $DashboardNetwork);
            
            foreach ($Values as $CityNameLoop => $City) {
                $CityConsumeTotals[$CityNameLoop] = ($CityConsumeTotals[$CityNameLoop] ?? 0) + $City[0];
            }
            
            $AllCSVCityData[$TypeOfCSV] += $CityConsumeTotals;
            
        } elseif ($RoleID == 3 && isset($CityFilter)) {
            $RoleNetworks = ['coteq','enexis','liander','stedin','westland-infra'];
            $NetworkConsumeTotals = array_fill_keys($RoleNetworks, 0);
            
            foreach ($RoleNetworks as $Net) {
                $Values = FilterByCityCSV($TypeOfCSV, $Year, $Net, $CityFilter);
                foreach ($Values as $CityNameLoop => $CityData) {
                    $NetworkConsumeTotals[$Net] += $CityData[11];
                }
            }
            
            $AllCSVCityData[$TypeOfCSV] += $NetworkConsumeTotals;
        }
    }
    
    // 🌆 CITY VIEW BLOCK
    foreach ($Types as $Type) {
        $CityAdditions = ['Annual' => 0, 'Connection' => 0, 'Delivery_Perc' => 0];
        $x = 1;
        $CityValues = [];
        
        if ($CityName) {
            foreach (['coteq','enexis','liander','stedin','westland-infra'] as $Net) {
                $CityGraphValues = FilterByCityCSV($Type, $Year, $Net, $CityName);
                foreach ($CityGraphValues as $Key => $City) {
                    $CityValues[$Key] = $City[11];
                    $CityAdditions['Annual'] += $City[11];
                    $CityAdditions['Connection'] += $City[9];
                    $CityAdditions['Delivery_Perc'] += $City[7];
                }
            }
        } else {
            $CityGraphValues = CSVData($Type, $Year, $Network);
            foreach ($CityGraphValues as $Key => $City) {
                $x++;
                $CityValues[$Key] = $City[0];
                $CityAdditions['Annual'] += $City[0];
                $CityAdditions['Connection'] += $City[1];
                $CityAdditions['Delivery_Perc'] += $City[2] / 100;
            }
        }
        
        $CityAdditions['Delivery_Perc'] /= $x;
        $AllCityDataForType[$Type] = $CityAdditions;
        $CityTypeValues[$Type] = $CityValues;
    }
    
    // 🛡️ ADMIN VIEW BLOCK
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        $Year = isset($_GET['Admin_Network_Year']) ? $_GET['Admin_Network_Year'] : '2016';
        $Type = isset($_GET['Admin_Network_Type']) ? $_GET['Admin_Network_Type'] : 'electricity';
        
        $Networks = ['coteq', 'enexis', 'liander', 'stedin', 'westland-infra'];
        $NetworkConsumeTotals = array_fill_keys($Networks, 0);
        
        foreach ($Networks as $Network) {
            $Values = CSVData($Type, $Year, $Network);
            foreach ($Values as $Value) {
                $NetworkConsumeTotals[$Network] += $Value[0];
            }
        }
        
        // 🟢 Output data for JavaScript use (ensure this is safely placed where JS can access)
        echo "<script>const networkGraphData = " . json_encode($NetworkConsumeTotals) . ";</script>";
    }
    
    // 🏭 NETWORK FILTER BLOCK
    $NetworkValue = CSVData($Type, $Year, $Network);
    $TotalNetworkConsume = [];
    
    foreach ($NetworkValue as $City => $Data) {
        $TotalNetworkConsume[$City] = ($TotalNetworkConsume[$City] ?? 0) + $Data[0];
    }
    $NetworkValueByType[$Type] = $TotalNetworkConsume;
?>

<script>
    // 📦 Shared variables
    const sharedColours = [
        '#003f5c', '#374c80', '#58508d', '#7a5195',
        '#bc5090', '#ff6361', '#ffa600'
    ];
    const font = { family: "Space Grotesk" };
    
    // 🏗️ Create chart variables
    let chartDashboard = null;
    let chartCity = null;
    let chartCityNetwork = null;
    let chartLine = null;
    let chartAdminDoughnut = null;
    let URI = null;
    
    // 📊 PHP-injected data
    const DashboardData = <?php echo json_encode($AllCSVCityData); ?>;
    const CityData = <?php echo json_encode($CityTypeValues['Electricity']); ?>;
    
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
    
    // 📊 Dashboard mixed chart [Dashboard]
    function drawDashboardGraph() {
        const canvas = document.getElementById("DashboardCanvas");
        
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
                    borderColor: '#00000000',
                    backgroundColor: sharedColours,
                    zIndex: 1,
                    hoverOffset: 10
                }, {
                    type: 'bar',
                    label: 'Electricity',
                    data: Object.values(DashboardData['Electricity']),
                    backgroundColor: sharedColours,
                    zIndex: 2
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
    
    // 🏙️ City electricity bar chart [City]
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
                    borderColor: "#975ae100",
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
                        console.log(URI);
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
    
    // 🏙️ Big city electricity bar chart [Network]
    function drawNetworkCityChart() {
        const canvas = document.getElementById("cityCanvasNetwork");
        
        // ✅ Ensure the canvas context is fresh
        if (!canvas) return; // 👋 Exit if canvas is missing
        const ctx = canvas.getContext("2d");
        
        console.log("▶️ City chart triggered.")
        
        // ⚠️ Provide actual data here
        const data = <?php echo json_encode($CityTypeValues['Electricity']); ?>;
        
        /*
        // 💥 Destroy existing chart properly
        if (chartCityNetwork) {
            chartCityNetwork.destroy();
            chartCityNetwork = null; // 🧹 Clear instance reference
        }
        */
        
        let chartCityNetwork = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    label: 'City Data',
                    data: Object.values(data),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 1
                }]
            },
            options: {
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
        console.log("✅ City chart loaded.")
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
    
    // 🍩 Network doughnut chart [Admin]
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
                    borderColor: "#975ae100",
                    backgroundColor: [
                        "#003f5c",
                        "#374c80",
                        "#58508d",
                        "#7a5195",
                        "#bc5090",
                    ],
                }],
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
        }, 250);
    });
    
    // 🔁 Redraw active chart(s) on theme change
    function redrawAllCharts() {
        drawDashboardGraph();
        drawBarGraph();
        drawLineChart();
        drawNetworkCityChart();
        drawNetworkDoughnut();
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