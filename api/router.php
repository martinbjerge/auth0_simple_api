<?php

  declare(strict_types=1);

  use Steampixel\Route;
  use Auth0\SDK\Token\Parser;

  function routeResponse(
    array $response
  ) {
    header('Content-Type: application/json');
    print(json_encode($response, JSON_PRETTY_PRINT));
  }

  // Simple test route that simulates static html file
  Route::add('/test.html', function() {
    return 'Welcome :-)';
  });
  
  Route::add('/api/public', function() use ($token) {
    if ($token === null) {
      $token_array = null;
    } else {
      $token_array = $token->toArray();
    }
    routeResponse([
      'message' => 'Hello from a public endpoint! You don\'t need to be authenticated to see this.',
      'token' => $token_array
    ]);

  });

  Route::add('/api/private', function() use ($token) {
    if ($token === null) {
      http_response_code(401);
      exit;
    } else {
      $token_array = $token->toArray();
      routeResponse([
        'message' => 'Hello from a private endpoint! You have been authenticated to see this.',
        'token' => $token_array,
      ]);
      }
  });

  Route::add('/api/private-scoped', function() use ($token, $configuration) {
    if ($token === null) {
      http_response_code(401);
      exit;
    }
    
    $token_array = $token->toArray();

    // Get user permisions
    $app_user_permissions = array();
    // Extract user information from request 
    if (isset($_SERVER['HTTP_AUTHORIZATION_USER']) && is_string($_SERVER['HTTP_AUTHORIZATION_USER'])){
      $parser_obj = new Parser($configuration, $_SERVER['HTTP_AUTHORIZATION_USER']);
      if ($parser_obj != null) {
        $app_user = $parser_obj->export();
        
        // Use the user ID (sub) to check user permisions 
        $curl = curl_init();
        curl_setopt_array($curl, [
          CURLOPT_URL => "https://".$_ENV['AUTH0_DOMAIN']."/api/v2/users/".$app_user['sub']."/permissions",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => [
            "authorization: Bearer ".$_ENV['AUTH0_MANAGEMENT_API_TOKEN']
          ],
        ]);
    
        $response = curl_exec($curl);
        $response = json_decode($response);
        $err = curl_error($curl);
        curl_close($curl);
        foreach ($response as $permission) {
          array_push($app_user_permissions, $permission->permission_name);
        }
      }
    }  

    // This scope need to be configures at manage.auth0.com
    if (! in_array('read:messages', $app_user_permissions, true)) {
      http_response_code(401);
      exit;
    }

    routeResponse([
      'message' => 'Hello from a private endpoint! You need to be authenticated and have a scope of read:messages to see this.',
      'token' => $token_array,
      'app_user_permissions' => $app_user_permissions,
      'app_user' => $app_user
    ]);
  });

  // The following route is just to avoid confusion.
  // We're not using an 'index route' in this app, so redirect requests to /api/public.
  Route::add('/', function() {
    header('Location: /api/public');
  });

  Route::run('');