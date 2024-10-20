<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
class DniController extends Controller
{
    public function consultaDni($dni)
    {
        $token = env('API_DNI_CONSULTA');
        $numero = $dni;
        $client = new Client(['base_uri' => 'https://api.apis.net.pe', 'verify' => false]);
        $parameters = [
            'http_errors' => true,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer '.$token,
                'Referer' => 'https://apis.net.pe/api-consulta-dni',
                'User-Agent' => 'laravel/guzzle',
                'Accept' => 'application/json',
            ],
            'query' => ['numero' => $numero]
        ];
        $res = $client->request('GET', '/v2/reniec/dni', $parameters);

        if ($res->getStatusCode() == 200) {
            $response = json_decode($res->getBody()->getContents(), true);
            // Resto del código
        } else {
            // Manejo de error en caso de que la solicitud no sea exitosa
        }

        return view('DniConsulta', ['dni' => $response]);
    }

    public function consultaDniPost($dni){
        try {
            $token = env('API_DNI_CONSULTA');
            $numero = $dni;
            $client = new Client(['base_uri' => 'https://api.apis.net.pe', 'verify' => false]);
            $parameters = [
                'http_errors' => true,
                'connect_timeout' => 5,
                'headers' => [
                    'Authorization' => 'Bearer '.$token,
                    'Referer' => 'https://apis.net.pe/api-consulta-dni',
                    'User-Agent' => 'laravel/guzzle',
                    'Accept' => 'application/json',
                ],
                'query' => ['numero' => $numero]
            ];
            $res = $client->request('GET', '/v2/reniec/dni', $parameters);

            if ($res->getStatusCode() == 200) {
                $response = json_decode($res->getBody()->getContents(), true);
                return $response;
            } else {
                $response =false;
                return $response;
            }
        } catch (\Throwable $th) {
            return null;
        }
    }
}
//https://api.apis.net.pe/v2/reniec/dni?numero=46027897
