<template>
  <div class="auth">
    <h2 class="my-5 text-center">Welcome to this Vue frontend demo.</h2>
    <div class="row">
        <p>This is an example on how to use Auth0 to login to your frontend and forward the credentials to an API.</p>
    </div>
    <!-- Check that the SDK client is not currently loading before accessing is methods -->
    <div v-if="!auth0Loading">
      <!-- show login when not authenticated -->
      <div v-if="!auth0IsAuthenticated">
        <p>To access data, you need to login. You can use your Google- or Facebook-account:</p>
        <button variant="primary" size="lg"  @click="login">Login</button>
      </div>
      <!-- show logout when authenticated -->
      <div v-if="auth0IsAuthenticated">
        <p> Now you can also logout again:</p>
        <button variant="primary" size="lg" @click="logout">Logout</button>
        <div>
          <h3>User info:</h3>
          <pre>{{ JSON.stringify(auth0User, null, 2) }}</pre>
          <button variant="primary" size="lg" @click="api">API</button>
          <h3>API answer:</h3>
          <pre>{{ api_data }}</pre>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AuthConfig from '@/auth_config.json'
export default {
  name: 'AuthView',
  components: {

  },
  data () {
    return {
      api_data: 'null',
      auth0User: this.$auth0.user,
      auth0IsAuthenticated: this.$auth0.isAuthenticated,
      auth0Loading: this.$auth0.loading
    }
  },
  methods: {
    // Log the user in
    login () {
      this.$auth0.loginWithRedirect()
    },
    // Log the user out
    logout () {
      this.$auth0.logout({
        logoutParams: {
          returnTo: window.location.origin
        }
      })
    },
    // Connect to API
    async api () {
      const ConfAudience = AuthConfig.audience
      const ConfApi = AuthConfig.api
      const differentAudienceOptions = {
        authorizationParams: {
          audience: ConfAudience,
          scope: 'read:all',
          redirect_uri: window.location.origin
        }
      }
      const accessToken = await this.$auth0.getAccessTokenSilently(differentAudienceOptions)
      // console.log('AccessToken:')
      // console.log(accessToken)

      const result = await fetch(ConfApi, {
        method: 'GET',
        headers: {
          Authorization: 'Bearer ' + accessToken
        }
      })
      this.api_data = await result.text()
      // console.log(this.api_data)
    }
  }
}
</script>
