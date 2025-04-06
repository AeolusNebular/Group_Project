var theme = false; // Track dark mode state
var chartInstance = null; // Store chart instance

document.addEventListener("DOMContentLoaded", function () {
    drawChart();
    window.addEventListener("resize", drawChart); // ✅ Attach resize event once
});

// Create chart
function drawChart() {
    let theme = document.body.classList.contains("light-mode");

    let font = { family: "Space Grotesk"};
                                
    // 🎨 Retrieve the current mode (light or dark) from sessionStorage for text colour
    const storedThemeMode = sessionStorage.getItem("themeMode")
    const [storedTheme, storedMode] = storedThemeMode.split("-");
    let textColor = storedMode === "light" ? "#000" : "#fff";

    let lineColor = theme ? "#aaa" : "#777";

    const canvas = document.getElementById("testChart");
    
    // ✅ Ensure the canvas context is fresh
    if (!canvas) return; // 👋 Exit if canvas is missing
    const ctx = canvas.getContext("2d");
    
    // 💥 Destroy existing chart properly
    if (chartInstance) {
        chartInstance.destroy();
        chartInstance = null; // 🧹 Clear instance reference
    }

    chartInstance = new Chart(ctx, {
        type: "line",
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
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: "bottom",
                    labels: { color: textColor, font: font },
                },
                title: { 
                    display: true, 
                    text: "Energy Usage Over Time", 
                    color: textColor, 
                    font: font 
                }
            },
            scales: {
                x: {
                    ticks: { color: textColor, font: font },
                    grid: { color: lineColor }
                },
                y: {
                    ticks: { color: textColor, font: font },
                    grid: { color: lineColor }
                }
            }
        }
    });
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
    
    let lineColor = isDarkMode ? "#888" : "#ccc";
    
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
} */
