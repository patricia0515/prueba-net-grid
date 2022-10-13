<?php

namespace App\Traits;

use DB;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

trait ConsumeApi
{
    /**
     * API Rick and Morty Url to send request
     */
    public $apiUrl;

    /**
     * send content to API API Rick and Morty.
     * @param  string  $url
     * @param  array   $data
     * @param  string  $resource
     * @return \Illuminate\Http\Response
     */
    public function getApi($url = null, $data = null, $resource = null)
    {
        /* $this->$apiUrl =  env('URL_RICK_MORTY_API');
        
        $this->$apiUrl = 'https://rickandmortyapi.com/api'.$resource; */
        $method = 'get';
        
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->{$method}('https://rickandmortyapi.com/api'.$resource);
        return $response;

        $client = new client([
            "headers" => [
                "Content-Type"  => "application/json",
                "Accept"        => "application/json"
            ],
        ]);
        
        $response = $client->get('https://rickandmortyapi.com/api'.$resource);
        

        if ($response->getStatusCode() === 200) {
            $response = $response->getBody()->getContents();
            $response = json_decode($response);
            return $response;
        }
    }
}
