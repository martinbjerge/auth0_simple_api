<?php

declare(strict_types=1);

// Set app root.
 define('APP_ROOT', realpath(__DIR__ . DIRECTORY_SEPARATOR));

// Import the files necessary for our Quickstart Application.
require('vendor/autoload.php');

use Auth0\Quickstart\Application;
use Auth0\Quickstart\Contract\QuickstartExample;
use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
use Steampixel\Route;

// Load configuration from .env file in project root.
(Dotenv\Dotenv::createImmutable(APP_ROOT))->load();

// The following globals don't get set during tests: apply some safe defaults.
 if (! isset($_SERVER['SERVER_PORT'])) {
     $_SERVER['SERVER_PORT'] = 80;
 }
 
 if (! isset($_SERVER['SERVER_NAME'])) {
     $_SERVER['SERVER_NAME'] = '127.0.0.1';
 }
 
 if (! isset($_SERVER['REQUEST_URI'])) {
     $_SERVER['REQUEST_URI'] = '/';
 }
 
// Now instantiate the Auth0 class with our configuration:
$auth0 = new \Auth0\SDK\Auth0([
    'domain' => $_ENV['AUTH0_DOMAIN'],
    'clientId' => $_ENV['AUTH0_CLIENT_ID'],
    'clientSecret' => $_ENV['AUTH0_CLIENT_SECRET'],
    'cookieSecret' => $_ENV['AUTH0_COOKIE_SECRET']
]);

// Define route constants:
define('ROUTE_URL_INDEX', rtrim($_ENV['AUTH0_BASE_URL'], '/'));
define('ROUTE_URL_LOGIN', ROUTE_URL_INDEX . '/login');
define('ROUTE_URL_CALLBACK', ROUTE_URL_INDEX . '/callback');
define('ROUTE_URL_LOGOUT', ROUTE_URL_INDEX . '/logout');


Route::add('/', function() use ($auth0) {
    $session = $auth0->getCredentials();
  
    if ($session === null) {
        // The user isn't logged in.
        echo '<p>Please <a href="/login">log in</a>.</p>';
        return;
    } else {
        // The user is logged in.
        echo "<h2>Session data ouput</h2>";
        echo '<pre>';
        print_r($session->user);
        echo '</pre>';
        // AccessToken
        echo "<h2>Access Token</h2>";
        echo '<pre>';
        print_r($session->accessToken);
        echo '</pre>';
        
        // Get a JWT 
        // https://community.auth0.com/t/why-is-my-access-token-not-a-jwt-opaque-token/31028
        echo "<h2>JWT Token</h2>";
        echo '<pre>';

        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "https://".$_ENV['AUTH0_DOMAIN']."/oauth/token",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "grant_type=client_credentials&client_id=".$_ENV['AUTH0_CLIENT_ID']."&client_secret=".$_ENV['AUTH0_CLIENT_SECRET']."&audience=".$_ENV['AUTH0_AUDIENCE'],
          CURLOPT_HTTPHEADER => [
            "content-type: application/x-www-form-urlencoded"
          ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
            $response = json_decode($response);
            echo $response->access_token;
    
        }
        echo '</pre>';

        // Connect to API and print answer 
        echo "<h2>Access API and print answer</h2>";
        echo '<pre>';
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $_ENV['API_ENTRY_URL'],
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => array(
            "authorization: Bearer $response->access_token"
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }
        echo '</pre>';

        echo '<p>You can now <a href="/logout">log out</a>.</p>';
    }
  });

Route::add('/login', function() use ($auth0) {
    // It's a good idea to reset user sessions each time they go to login to avoid "invalid state" errors, should they hit network issues or other problems that interrupt a previous login process:
    $auth0->clear();

    // Finally, set up the local application session, and redirect the user to the Auth0 Universal Login Page to authenticate.
    header("Location: " . $auth0->login(ROUTE_URL_CALLBACK));
    exit;
});

Route::add('/callback', function() use ($auth0) {
    // Have the SDK complete the authentication flow:
    $auth0->exchange(ROUTE_URL_CALLBACK);

    // Finally, redirect our end user back to the / index route, to display their user profile:
    header("Location: " . ROUTE_URL_INDEX);
    exit;
});


Route::add('/logout', function() use ($auth0) {
    // Clear the user's local session with our app, then redirect them to the Auth0 logout endpoint to clear their Auth0 session.
    header("Location: " . $auth0->logout(ROUTE_URL_INDEX));
    exit;
});

// This tells our router that we've finished configuring our routes, and we're ready to begin routing incoming HTTP requests:
Route::run('/');