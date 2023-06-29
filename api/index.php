<?php

  declare(strict_types=1);

  require('vendor/autoload.php');
  
  use Auth0\SDK\Auth0;
  use Auth0\SDK\Configuration\SdkConfiguration;

  define('APP_ROOT', realpath(__DIR__ . DIRECTORY_SEPARATOR));
  (Dotenv\Dotenv::createImmutable(APP_ROOT))->load();

  $configuration = new SdkConfiguration(
    strategy: SdkConfiguration::STRATEGY_API,
    domain: $_ENV['AUTH0_DOMAIN'],
    clientId: $_ENV['AUTH0_CLIENT_ID'],
    clientSecret: $_ENV['AUTH0_CLIENT_SECRET'],
    audience: [$_ENV['AUTH0_AUDIENCE']]
  );

  $sdk = new Auth0($configuration);

  $token = $sdk->getBearerToken(
    get: ['token'],
    server: ['HTTP_AUTHORIZATION']
  );

  require('router.php');
