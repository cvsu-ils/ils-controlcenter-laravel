<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class APIController extends Controller
{
    public function auth($email, $password) {
        $response = Http::post('http://library.cvsu.edu.ph/sandbox/laravel/api/oauth/token', [
            'email' => $email,
            'password' => $password,
        ]);

        // Check if the request was successful
        if ($response->successful()) {
            // Handle successful response
            $data = $response->json();

            return $data['token'];
        } else {
            return false;
        }
    }

    public function request($method, $endpoint, $data = []) {
        $email = 'wifilogs@library.cvsu.edu.ph';
        $password = 'w!f!l0gs2024';

        $token = $this->auth($email, $password);

        $headers = [
            'Authorization' =>  'Bearer ' . $token,
            'Content-Type' => 'application/json' 
        ];

        $response = NULL;

        switch($method) {
            default:
            case 'get':
                $response = Http::withHeaders($headers)->get($endpoint, $data);
                break;
            case 'patch':
                $response = Http::withHeaders($headers)->patch($endpoint, $data);
                break;
            case 'post':
                $response = Http::withHeaders($headers)->post($endpoint, $data);
                break;
        }
        
        $body = $response->getBody()->getContents();
        $statusCode = $response->getStatusCode();
        $data = json_decode($body, true);

        return array_merge($data, ['statusCode' => $statusCode]);
    }
}
