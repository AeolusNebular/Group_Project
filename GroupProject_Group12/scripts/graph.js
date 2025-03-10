// Load Google Charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

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
        legend: { position: 'bottom' },
        backgroundColor: 'transparent', 
        hAxis: { textStyle: { color: '#fff' } },
        vAxis: { textStyle: { color: '#fff' } },
        titleTextStyle: { color: '#fff' },
        legendTextStyle: { color: '#fff' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('myChart'));
    chart.draw(data, options);

    // Resizing
    window.addEventListener('resize', drawChart);
}

// !! This is just me testing out the google charts stuff, doesn't have to stick around :)