<?php

class Tiempo  {
    private $respuesta;

    private $urlTiempo       = 'https://api.openweathermap.org/data/2.5/weather?';
    private $urlLocalizacion = "https://api.opencagedata.com/geocode/v1/json";

    private $opciones;
    private $revGeocodeUrl;

    public function __construct($la, $lo)   {
        include("../../claves.inc.php");

        // Preparar datos acceso a consulta REST tiempo:
        $urlCompleto = $this->urlTiempo . '&lat=' . $la . "&lon=" . $lo . "&units=metric". "&lang=es" ."&appid=" . $keyOpenWeatherMap;

        $this->opciones = array(
            CURLOPT_URL => $urlCompleto,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache"
            )
        ); 

        // Preparar datos acceso servicio localizacion OpenCage (reemplaza Bing Maps):
        $this->revGeocodeUrl = $this->urlLocalizacion . "?q={$la}+{$lo}&language=es&key={$keyOpenCage}";
    }

    public function getTiempo()  {
        $ch = curl_init();
        curl_setopt_array($ch, $this->opciones);
        $respuesta = curl_exec($ch);
        curl_close($ch);

        $salida = json_decode($respuesta, true);

        return $salida;
    }

    public function getLocalizacion() {
        $salida  = file_get_contents($this->revGeocodeUrl);
        $salida1 = json_decode($salida, true);

        $components = $salida1["results"][0]["components"];
        $formatted  = $salida1["results"][0]["formatted"];

        // Mapear los campos de OpenCage a la estructura que espera Datos.php
        // formattedAddress -> formatted
        // locality -> city / town / village
        // adminDistrict2 -> county / state_district
        // countryRegion -> country
        $locality = $components['city'] 
            ?? $components['town'] 
            ?? $components['village'] 
            ?? $components['municipality'] 
            ?? '';

        $adminDistrict2 = $components['county'] 
            ?? $components['state_district'] 
            ?? $components['state'] 
            ?? '';

        $countryRegion = $components['country'] ?? '';

        return array(
            'formattedAddress' => $formatted,
            'locality'         => $locality,
            'adminDistrict2'   => $adminDistrict2,
            'countryRegion'    => $countryRegion
        );
    }
}
