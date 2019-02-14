<?php
    require 'vendor/autoload.php';

    use GuzzleHttp\Client;
    use GuzzleHttp\Exception\RequestException;
    use GuzzleHttp\Psr7\Request;

    class TestApi
    {
        private $client = null;
        const URL = 'http://api.population.io:80/1.0/';
        
        public function __construct()
        {
            $this->client = new Client();
        }

        public function getCountries($start, $end)
        {
            try {
                $url = self::URL . 'countries';
                $header = array('Accept' => 'application/json','Content-type' => 'application/json');
                $response = $this->client->get($url, array('headers' => $header));
                $array = json_decode($response->getBody(), true);
                $result = [];
                $i = 0;
                foreach($array as $a) {
                    foreach($a as $element) {
                        if(preg_match('/^[' . $start . '-' . $end . '][a-z]+/i', $element)) {
                            $result[$i] = $element;
                            $i++;
                        }
                    }
                }
                return $result;
            } catch (RequestException $e) {
                $response = $this->StatusCodeHandling($e);
                return $response;
            }
        }

        public function getPopulation($country, $year, $age, $gender)
        {
            try {
                $url = self::URL . 'population/' . $year . '/' . $country . '/' . $age;
                $header = array('Accept' => 'application/json','Content-type' => 'application/json');
                $response = $this->client->get($url, array('headers' => $header));
                $array = json_decode($response->getBody(), true);
                return $array[0][$gender];
            } catch (RequestException $e) {
                $response = $this->StatusCodeHandling($e);
                return $response;
            }
        }
    }