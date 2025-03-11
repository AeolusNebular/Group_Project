let isDarkMode = false; // Track dark mode state
let chartInstance = null; // Store chart instance

document.addEventListener("DOMContentLoaded", function () {
    drawChart();
    window.addEventListener("resize", drawChart); // ✅ Attach resize event once
});

// Create chart
function drawChart() {
    const canvas = document.getElementById("testChart");
    
    // ✅ Ensure the canvas context is fresh
    if (!canvas) return; // Exit if canvas is missing
    const ctx = canvas.getContext("2d");

    // ✅ Destroy existing chart properly
    if (chartInstance) {
        chartInstance.destroy();
        chartInstance = null; // Clear instance reference
    }

    chartInstance = new Chart(ctx, {
        type: "line",
        data: {
            labels: ["2020", "2021", "2022", "2023"],
            datasets: [{
                label: "Energy Usage",
                data: [1000, 1170, 660, 1030],
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
                    labels: { color: isDarkMode ? "#000" : "#fff" }
                },
                title: {
                    display: true,
                    text: "Energy Usage Over Time",
                    color: isDarkMode ? "#000" : "#fff"
                }
            },
            scales: {
                x: { ticks: { color: isDarkMode ? "#000" : "#fff" } },
                y: { ticks: { color: isDarkMode ? "#000" : "#fff" } }
            }
        }
    });
}