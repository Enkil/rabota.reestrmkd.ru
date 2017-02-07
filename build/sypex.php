<?php
require_once ('./settings.php');

// SypexGeo
$ip = $_SERVER['REMOTE_ADDR'];
$spgeo_api_req = file_get_contents('http://api.sypexgeo.net/'. $settings['sypexGeoApiKey'] .'/json/'. $ip .'?lng=ru');
$geodata = json_decode($spgeo_api_req,true);
$region = $geodata['region']['name_ru'];
$city = $geodata['city']['name_ru'];
$country = $geodata['country']['name_ru'];
$utc = $geodata['region']['utc'];
$timezone = $geodata['region']['timezone'];
date_default_timezone_set($timezone);
$region_time = date("Y-m-d H:i:s");