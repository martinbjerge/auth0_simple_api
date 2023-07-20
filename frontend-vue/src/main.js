import Vue from 'vue'
import App from './App.vue'
import router from './router'

// Import the Auth0 configuration
import AuthConfig from '../auth_config.json'

// Import the plugin here
import { Auth0Plugin } from './auth'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import { BootstrapVue } from 'bootstrap-vue'

// Install the authentication plugin here
const domain = AuthConfig.domain
const clientId = AuthConfig.clientId
const audience = AuthConfig.audience
Vue.use(Auth0Plugin, {
  domain,
  clientId,
  authorizationParams: {
    audience: audience
  },
  onRedirectCallback: appState => {
    router.push(
      appState && appState.targetUrl
        ? appState.targetUrl
        : window.location.pathname
    )
  }
})

Vue.config.productionTip = false

Vue.use(BootstrapVue)

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')

Vue.use(BootstrapVue)
