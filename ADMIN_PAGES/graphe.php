<?php
// Inclure le fichier de connexion à la base de données
include("../connexion/connexion-DB.php");

// Récupérer les données pour le revenu par mois
$currentYear = date('Y');

// Define an array of month names
$monthNames = array(
    "January", "February", "March", "April", "May", "June", 
    "July", "August", "September", "October", "November", "December"
);

$stmt1 = $connexion->prepare("SELECT MONTH(date_buy) AS mois, SUM(price) AS revenu 
                         FROM buy 
                         WHERE YEAR(date_buy) = ? 
                         GROUP BY mois");
$stmt1->bind_param("i", $currentYear);
$stmt1->execute();

$result1 = $stmt1->get_result();

$dataPointsRevenue = [];
while ($row = $result1->fetch_assoc()) {
    $monthIndex = $row['mois'] - 1; // Month index starts from 1, but array index starts from 0
    $monthName = $monthNames[$monthIndex]; // Get the month name from the array
    $dataPointsRevenue[] = array("label" => $monthName, "y" => $row['revenu']);
}

// Récupérer les données pour la répartition des genres de livres vendus
$stmt2 = $connexion->prepare("SELECT genre, COUNT(*) AS nombre_ventes
                         FROM livre l
                         GROUP BY genre");
$stmt2->execute();

$result2 = $stmt2->get_result();

$dataPointsGenres = [];
while ($row = $result2->fetch_assoc()) {
    $dataPointsGenres[] = array("label" => $row['genre'], "y" => $row['nombre_ventes']);
}

// Calculate total number of book sales
$totalSales = array_sum(array_column($dataPointsGenres, 'y'));

// Calculate percentages for each genre
foreach ($dataPointsGenres as &$point) {
    $point['y'] = ($point['y'] / $totalSales) * 100;
}
?>

<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

<div class="row">
    <div class="col-sm">
        <div id="chartContainer" style="height: 300px; width: 100%;"></div>
    </div>
</div>
<div class="row">
    <div class="col-sm">
        <div id="chartContainer1" style="height: 300px; width: 100%;"></div>
    </div>
</div>

<script>
    window.onload = function() {
        var chartRevenue = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            title: {
                text: "Revenue per Month for the Year <?php echo $currentYear; ?>"
            },
            axisY: {
                title: "Revenue ($)"
            },
            data: [{
                type: "column",
                dataPoints: <?php echo json_encode($dataPointsRevenue, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chartRevenue.render();


        var chartGenres = new CanvasJS.Chart("chartContainer1", {
            animationEnabled: true,
            title: {
                text: "Distribution of Book Genres Sold"
            },
            data: [{
                type: "pie",
                startAngle: 240,
                yValueFormatString: "##0.00\"%\"",
                indexLabel: "{label} {y}",
                dataPoints: <?php echo json_encode($dataPointsGenres, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chartGenres.render();

    }
</script>
