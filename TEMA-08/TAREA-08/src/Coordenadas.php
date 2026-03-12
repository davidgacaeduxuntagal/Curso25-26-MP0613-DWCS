<?php
class Coordenadas  {
    private static $keyOpenCage = "";
    private static $keyGeoapify = "";
    // Localidad por defecto para las búsquedas (cambia "Cangas" por tu localidad)
    private static $localidad = "Cangas";
    private $direccion;

    public function __construct()  {
        include("../../claves.inc.php");
        self::$keyOpenCage = $keyOpenCage;
        self::$keyGeoapify = $keyGeoapify;

        $num = func_num_args();

        if ($num == 1) {
            $this->direccion = func_get_arg(0);
        }
    }

    /**
     * Geocodificación con OpenCage: dirección → coordenadas
     */
    public function getCoordenadas()  {
        $query = self::$localidad . ", " . $this->direccion . ", ES";
        $query = urlencode($query);
        $url   = "https://api.opencagedata.com/geocode/v1/json?q=$query&limit=1&language=es&key=" . self::$keyOpenCage;

        $salida  = file_get_contents($url);
        $salida1 = json_decode($salida, true);

        if (empty($salida1["results"])) {
            return [0, 0, 0];
        }

        $lat = $salida1["results"][0]["geometry"]["lat"];
        $lon = $salida1["results"][0]["geometry"]["lng"];
        $alt = $this->calculaAltitud([$lat, $lon]);

        return [$lat, $lon, $alt];
    }

    /**
     * Altitud con Open-Elevation (gratuito, sin clave)
     */
    public function calculaAltitud($c)  {
        $lat = $c[0];
        $lon = $c[1];
        $url = "https://api.open-elevation.com/api/v1/lookup?locations=$lat,$lon";

        $salida = file_get_contents($url);
        $valor  = json_decode($salida, true);

        if (isset($valor["results"][0]["elevation"])) {
            return $valor["results"][0]["elevation"];
        }
        return 0;
    }

    /**
     * Optimización de ruta con Geoapify Route Planner API
     * Recibe los waypoints como "lat1,lon1|lat2,lon2|..."
     * Devuelve el orden óptimo de los waypoints (sin incluir almacén)
     */
    public function ordenarEnvios($dato)   {
        // Coordenadas del almacén (inicio y fin de la ruta)
        $almacenLat = 36.86071;
        $almacenLon = -2.440779;

        $puntos = explode("|", $dato);

        // Construir el cuerpo JSON para Geoapify Route Planner
        // mode=drive, agente sale del almacén y vuelve al almacén
        $jobs = [];
        for ($i = 0; $i < count($puntos); $i++) {
            $coords = explode(",", $puntos[$i]);
            $lat = floatval(trim($coords[0]));
            $lon = floatval(trim($coords[1]));
            $jobs[] = [
                "location" => [$lon, $lat],  // Geoapify usa [lon, lat]
                "id" => strval($i + 1)
            ];
        }

        $body = [
            "mode" => "drive",
            "agents" => [
                [
                    "start_location" => [$almacenLon, $almacenLat],
                    "end_location"   => [$almacenLon, $almacenLat],
                    "id" => "driver1"
                ]
            ],
            "jobs" => $jobs
        ];

        $url = "https://api.geoapify.com/v1/routeplanner?apiKey=" . self::$keyGeoapify;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        $salida = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (!$salida || $httpCode == 404 || $httpCode >= 400) {
            return "404";
        }

        $salida1 = json_decode($salida, true);

        if (!isset($salida1["features"][0]["properties"]["actions"])) {
            return "404";
        }

        $actions = $salida1["features"][0]["properties"]["actions"];
        $resp = [];

        foreach ($actions as $action) {
            // Cada acción de tipo "job" tiene el job_id que corresponde al índice original
            if (isset($action["type"]) && $action["type"] === "job") {
                $resp[] = $action["job_id"];
            }
        }

        return $resp;
    }

    public function getRemoteFile($url, $timeout = 10)  {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_contents = curl_exec($ch);
        curl_close($ch);

        return ($file_contents) ? $file_contents : FALSE;
    }
}