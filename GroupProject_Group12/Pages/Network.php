<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <link rel="stylesheet" href="/Group_Project/GroupProject_Group12/style.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="/Group_Project/GroupProject_Group12/scripts/sidebar.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/graph.js"></script>
    <script src="/Group_Project/GroupProject_Group12/scripts/darkmode.js"></script>

    <title>Network - Smart Energy Dashboard</title>
</head>

<body>
  
    <!-- Navbar -->
    <?php include("../navbar.php"); ?>
    

    <div id="testing" style="margin-left: 48px;">

        <div style="text-align: center">
            <h2 style="color: white">Network:</h2>
        </div>

        <div style="text-align: center; margin-bottom: 20px;">
            <label for="cityFilter" style="color: white;">Filter by City:</label>
            <select id="cityFilter" onchange="filterData()">
                <option value="all">All</option>
                <option value="Enexis">Enexis</option>
                <option value="Liander">Liander</option>
                <option value="Stedin">Stedin</option>
                <option value="Enduris">Enduris</option>
                <option value="Westlandinfra">Westlandinfra</option>
                <option value="Rendo">Rendo</option>
                <option value="Coteq">Coteq</option>
                <!-- Add more cities as needed -->
            </select>
        </div>

        <canvas id="cityChart" width="400" height="150"></canvas>

        <script>
            const cityData = {
                all: [12, 19, 3, 5, 2, 3, 7],
                Enexis: [12, 19, 3, 5, 2, 3, 7],
                Liander: [2, 3, 20, 5, 1, 4, 6],
                Stedin: [3, 10, 13, 15, 22, 30, 8],
                Enduris: [5, 12, 8, 6, 9, 10, 11],
                Westlandinfra: [7, 14, 9, 11, 13, 17, 5],
                Rendo: [4, 8, 6, 9, 12, 15, 10],
                Coteq: [6, 11, 7, 10, 14, 18, 9]
                // Add more city data as needed
            };

            const ctx = document.getElementById('cityChart').getContext('2d');
            let cityChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                    datasets: [{
                        label: 'City Data',
                        data: cityData.all,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: 'white' // Set y-axis text color to white
                            }
                        },
                        x: {
                            ticks: {
                                color: 'white' // Set x-axis text color to white
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white' // Set legend text color to white
                            }
                        }
                    }
                }
            });

            function filterData() {
                const selectedCity = document.getElementById('cityFilter').value;
                cityChart.data.datasets[0].data = cityData[selectedCity];
                cityChart.update();
            }
        </script>

    </div>

</body>
</html>