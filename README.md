<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## controller::get_token
    //Get client_secret.json:
    //https://github.com/googleapis/google-api-php-client/blob/main/docs/oauth-web.md#create-authorization-credentials
    //https://console.developers.google.com/apis/credentials
    //URI redirect: http://127.0.0.1:8000
    //Note: It may take 5 minutes to a few hours for settings to take effect
    
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
            dd($access_token, $client);
        }

        $auth_url = $client->createAuthUrl();
        header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        exit;

## controller::firebase_remote_config
        // ----- get list remote config
        $access_token = '';
        $project_id = '';

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
