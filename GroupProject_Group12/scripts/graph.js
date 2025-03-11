// Load Google Charts
google.charts.load('current', { packages: ['corechart'] });
google.charts.setOnLoadCallback(initChart);

let isDarkMode = true; // Track dark mode state

function initChart() {
    drawChart();
    window.addEventListener("resize", drawChart); // ✅ Attach resize event once
}

// Create chart
function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Year', 'Energy Usage'],
        ['2020',  1000],
        ['2021',  1170],
        ['2022',  660],
        ['2023',  1030]
    ]);

    // Text and formatting
    var options = {
        title: 'Energy Usage Over Time',
        curveType: 'function',
        legend: { position: 'bottom', textStyle: { color: isDarkMode ? "#fff" : "#000" } },
        backgroundColor: 'transparent',
        hAxis: { textStyle: { color: isDarkMode ? "#fff" : "#000" } },
        vAxis: { textStyle: { color: isDarkMode ? "#fff" : "#000" } },
        titleTextStyle: { color: isDarkMode ? "#fff" : "#000" }
    };

    var chart = new google.visualization.LineChart(document.getElementById('myChart'));
    chart.draw(data, options);
}

// Dark mode toggle
function toggledarklight() {
    var element = document.body;
    element.classList.toggle("dark-mode");
    isDarkMode = element.classList.contains("dark-mode"); // Update state
    drawChart(); // 🔄 Redraw chart immediately
}