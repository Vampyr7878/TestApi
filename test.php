<?php
    include 'api.php';

    $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
    $api = new TestApi();
    if($request[0] == 'countries') {
        $countires[0] = $api->getCountries($request[1], $request[2]);
        $result = json_encode($countires);
        echo $result;
    } elseif($request[0] == 'population') {
        $population[0] = $api->getPopulation($request[1], $request[2], $request[3], $request[4]);
        $result = json_encode($population);
        echo $result;
    }