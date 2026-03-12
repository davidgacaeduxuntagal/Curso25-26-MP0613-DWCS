<?php
if (!isset($_POST['wp'])) {
    header('Location:repartos.php');
    die();
}
$wp = $_POST['wp'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Ruta de Reparto</title>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="utf-8" />
    <!-- Leaflet CSS y JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Leaflet Routing Machine (usa OSRM gratuito por defecto) -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css" />
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.min.js"></script>
</head>

<body style="background:#00bfa5;">
    <div class="container mt-3 ">
        <div class="d-flex justify-content-center">
            <div id="myMap" style="width:650px;height:420px;"></div>
        </div>
        <div class="d-flex justify-content-center mt-3">
            <a href='repartos.php' class='btn btn-warning'>Volver</a>
        </div>
    </div>

    <script type='text/javascript'>
        // Crear el mapa centrado en el primer waypoint
        var waypoints = [
            <?php
            for ($i = 0; $i < count($wp); $i++) {
                $coords = explode(",", $wp[$i]);
                $lat = trim($coords[0]);
                $lon = trim($coords[1]);
                echo "L.latLng($lat, $lon)";
                if ($i < count($wp) - 1) echo ",\n            ";
            }
            ?>
        ];

        var map = L.map('myMap').setView(waypoints[0], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Leaflet Routing Machine con OSRM (gratuito)
        L.Routing.control({
            waypoints: waypoints,
            routeWhileDragging: false,
            lineOptions: {
                styles: [{color: 'green', opacity: 0.8, weight: 6}]
            },
            show: true,       // Muestra las instrucciones de ruta
            addWaypoints: false,
            router: L.Routing.osrmv1({
                serviceUrl: 'https://router.project-osrm.org/route/v1'
            })
        }).addTo(map);
    </script>
</body>

</html>