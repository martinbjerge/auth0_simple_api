# auth0_simple_api
Example of how to setup a simple API and protect it with AUTH0 and how to access it.

## API setup

See: <br>
https://getcomposer.org/download/ <br>
https://auth0.com/docs/quickstart/backend/php/01-authorization <br>
https://auth0.com/docs/manage-users/access-control/configure-core-rbac/rbac-users/view-user-permissions <br>

### Composer install at websever


```
mkdir api
cd api/
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

php composer.phar require auth0/auth0-php steampixel/simple-php-router vlucas/phpdotenv
```

## Test setup

See: <br>
https://auth0.com/docs/quickstart/webapp/php <br>
https://jwt.io/ <br>
https://community.auth0.com/t/auth0-php-regular-web-app-api/108734/12 <br>

### Composer install at websever

```
mkdir test
cd test/
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

php composer.phar require auth0/auth0-php steampixel/simple-php-router vlucas/phpdotenv
```
