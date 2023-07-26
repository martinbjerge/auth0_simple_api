# Frontend Vue - Demo connect to API

## Project setup
### Setup in Windows 
Install npm from https://nodejs.org/en/download

```
npm install -g @vue/cli
```

### General setup
```
npm config set legacy-peer-deps=true --location=project
npm install 
```

### Compiles and hot-reloads for development
```
npm run serve
```

### Compiles and minifies for production
```
npm run build
```

### Lints and fixes files
```
npm run lint
```

### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).


# Notes on how to buid this app

## Akitecture 

Idea is to have this a vue single page app (SPA) as the front-end, and this make this app access & modify data via an API. 

I will use Auth0 to verify users, and the API would then also need to have the user verified before data can be exchanged with the front-end. 

Guide to php based API's: https://auth0.com/docs/quickstart/backend/php/01-authorization

## Usefull how to's

https://auth0.com/docs/libraries/auth0-single-page-app-sdk#get-access-token-for-a-different-audience

https://code.tutsplus.com/tutorials/authentication-and-authorization-using-auth0-in-php--cms-31134

https://developer.auth0.com/resources/guides/spa/vue/basic-authentication
https://auth0.com/docs/get-started/authentication-and-authorization-flow/authorization-code-flow-with-proof-key-for-code-exchange-pkce
https://auth0.com/docs/microsites/call-api/call-api-single-page-app

