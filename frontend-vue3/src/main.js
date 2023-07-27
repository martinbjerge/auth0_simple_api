import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import VueNavigationBar from 'vue-navigation-bar'
import 'vue-navigation-bar/dist/vue-navigation-bar.css'
import { createAuth0 } from '@auth0/auth0-vue'
// Import the Auth0 configuration
import AuthConfig from '@/auth_config.json'

const app = createApp(App)
const ConfDomain = AuthConfig.domain
const ConfClientId = AuthConfig.clientId

app.use(
  createAuth0({
    domain: ConfDomain,
    clientId: ConfClientId,
    authorizationParams: {
      redirect_uri: window.location.origin
    }
  })
)

app.use(router)

app.component('vue-navigation-bar', VueNavigationBar)

app.mount('#app')
