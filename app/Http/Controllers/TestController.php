<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Cache;

class TestController extends Controller
{
    public function get_token()
    {
        //Get client_secret.json:
        //https://github.com/googleapis/google-api-php-client/blob/main/docs/oauth-web.md#create-authorization-credentials
        //https://console.developers.google.com/apis/credentials
        //URI redirect: http://127.0.0.1:8000
        //Note: It may take 5 minutes to a few hours for settings to take effect
        //
        $dir = __DIR__ . "/../../../client_secret.json"; /* ../Project/client_secret.json */

        $client = new \Google_Client(); //composer require google/apiclient
        $client->setAuthConfig($dir);
        $client->setRedirectUri('http://127.0.0.1:8000'); /* http://127.0.0.1:8000 not http://localhost:8000 */
        $client->addScope('https://www.googleapis.com/auth/cloud-platform');
        $client->setAccessType('offline');
        $client->setIncludeGrantedScopes(true);
        $client->setPrompt('consent');

        if (isset($_GET['code'])) { //when redirect
            $client->authenticate($_GET['code']);
            $token = $client->getAccessToken();
            $access_token = $token['access_token'];
            Cache::forever('google_access_token', $access_token);
            echo 'Đã cập nhật access token';
            die();
        }

        $auth_url = $client->createAuthUrl();
        header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        exit;
    }

    public function firebase_remote_config()
    {
        // ----- get list remote config
        $access_token = 'ya29.a0AWY7CkmG2RvITxkJgPqgtXAurkNGqAZW6hK6BHef4UuIc5z1TjZtMlKmXP1hLfwBay8u0sk054ZKUXPrzBqLDT-uu6vFu_lp5LEWNyohprMKUtJdvXH1Nncy-Gl9u2Z_fkbkF38JK--P1sQqXwSss0HALRWSaCgYKAUASARISFQG1tDrps0rgDG8KoU0lAxcZGUCT-g0163 ◀ya29.a0AWY7CkmG2RvITxkJgPqgtXAurkNGqAZW6hK6BHef4UuIc5z1TjZtMlKmXP1hLfwBay8u0sk054ZKUXPrzBqLDT-uu6vFu_lp5LEWNyohprMKUtJdvXH1Nncy-Gl9u2Z_fkbkF38JK--P1sQqXwSss0HAL';
        $project_id = 'myproject2-27cf6';

        $curl = curl_init();
        $header[] = "Content-Type: application/json";
        $header[] = "Authorization: Bearer " . $access_token;
        $URL = "https://firebaseremoteconfig.googleapis.com/v1/projects/$project_id/remoteConfig";

        curl_setopt($curl, CURLOPT_URL, $URL);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($response, true);

        dd($response);

        // ----- update remote config

//        //dd($response['parameters']['rm_project_2']['defaultValue']['value']);
//        $response['parameters']['rm_project_2']['defaultValue']['value'] = "value changed";
//        $header[] = 'If-Match: *';
//
//        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_URL, $URL);
//        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
//        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
//        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($response));
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        $response2 = curl_exec($curl);
//        curl_close($curl);
//        dd($response2);
    }

//    public function getToken2(){
//        $client_id = "";
//        $client_secret = "";
//        $refresh_token = "";
//
//        $curl_token = curl_init();
//        $URL = "https://oauth2.googleapis.com/token";
//        $header_token[] = "Content-Type: application/x-www-form-urlencoded";
//        $body = "client_id=". $client_id ."&client_secret=". $client_secret ."&refresh_token=". $refresh_token ."&grant_type=refresh_token";
//        curl_setopt($curl_token, CURLOPT_HTTPHEADER, $header_token);
//        curl_setopt($curl_token, CURLOPT_POSTFIELDS, $body);
//        curl_setopt($curl_token, CURLOPT_URL, $URL);
//        curl_setopt($curl_token, CURLOPT_CUSTOMREQUEST, "POST");
//        curl_setopt($curl_token, CURLOPT_RETURNTRANSFER, true);
//        $response_token = curl_exec($curl_token);
//        curl_close($curl_token);
//        $response_token = json_decode($response_token, true);
//        $access_token = $response_token['access_token'];
//    }
}
