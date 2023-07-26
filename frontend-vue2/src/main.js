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
const ConfDomain = AuthConfig.domain
const ConfClientId = AuthConfig.clientId
Vue.use(Auth0Plugin, {
  domain: ConfDomain,
  clientId: ConfClientId,
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
