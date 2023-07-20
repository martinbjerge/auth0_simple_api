<template>
  <div>
    <h2 class="my-5 text-center">Welcome to this Vue frontend demo.</h2>
    <div class="row">
        <p>This is an example on how to use Auth0 to login to your frontend and forward the credentials to an API.</p>
    </div>

    <!-- Check that the SDK client is not currently loading before accessing is methods -->
    <div v-if="!$auth.loading">
      <!-- show login when not authenticated -->
      <p v-if="!$auth.isAuthenticated">To access data, you need to login. You can use your Google- or Facebook-account:</p>
      <b-button variant="primary" size="lg" v-if="!$auth.isAuthenticated" @click="login">Login</b-button>
      <!-- show logout when authenticated -->
      <p v-if="$auth.isAuthenticated"> Now you can also logout again:</p>
      <div>
      <pre>{{ JSON.stringify($auth.user, null, 2) }}</pre>
      <pre>{{ api_data }}</pre>
      </div>

      <b-button variant="primary" size="lg" v-if="$auth.isAuthenticated" @click="logout">Logout</b-button>
      <b-button variant="primary" size="lg" v-if="$auth.isAuthenticated" @click="api">API</b-button>
    </div>

  </div>
</template>

<script>
import AuthConfig from '../../auth_config.json'
export default {
  name: 'HomeView',
  components: {

  },
  data () {
    return {
      api_data: 'null'
    }
  },
  methods: {
    // Log the user in
    login () {
      this.$auth.loginWithRedirect()
    },
    async api () {
      const audience = AuthConfig.audience
      const api = AuthConfig.api
      const idToken = await this.$auth.getIdTokenClaims()
      const accessToken = await this.$auth.getTokenSilently({ audience: audience, detailedResponse: true })
      console.log('AccessToken:')
      console.log(accessToken)
      console.log('Bearer ' + accessToken.id_token)
      console.log('idToken:')
      console.log(idToken)
      console.log(idToken.__raw)

      const result = await fetch(api, {
        method: 'GET',
        headers: {
          Authorization: 'Bearer ' + accessToken.id_token
        }
      })
      this.api_data = await result.text()
      // this.api_data = result
      console.log(this.api_data)
    },
    // Log the user out
    logout () {
      this.$auth.logout({
        logoutParams: {
          returnTo: window.location.origin
        }
      })
    }
  }
}
</script>
