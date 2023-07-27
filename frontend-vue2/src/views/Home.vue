<template>
  <div>
    <h2 class="my-5 text-center">Welcome to this Vue frontend demo.</h2>
    <div class="row">
        <p>This is an example on how to use Auth0 to login to your frontend and forward the credentials to an API.</p>
    </div>

    <!-- Check that the SDK client is not currently loading before accessing is methods -->
    <div v-if="!$auth.loading">
      <!-- show login when not authenticated -->
      <div v-if="!$auth.isAuthenticated">
        <p>To access data, you need to login. You can use your Google- or Facebook-account:</p>
        <b-button variant="primary" size="lg" @click="login">Login</b-button>
      </div>
      <!-- show logout when authenticated -->
      <div v-if="$auth.isAuthenticated">
        <p> Now you can also logout again:</p>
        <b-button variant="primary" size="lg" @click="logout">Logout</b-button>
        <div>
          <h3>User info:</h3>
          <pre>{{ JSON.stringify($auth.user, null, 2) }}</pre>
          <b-button variant="primary" size="lg" @click="api">API</b-button>
          <h3>API answer:</h3>
          <pre>{{ api_data }}</pre>
        </div>
      </div>
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
      const ConfAudience = AuthConfig.audience
      const ConfApi = AuthConfig.api
      const differentAudienceOptions = {
        authorizationParams: {
          audience: ConfAudience,
          scope: 'read:all',
          redirect_uri: window.location.origin
        }
      }
      const accessToken = await this.$auth.getTokenSilently(differentAudienceOptions)
      console.log('AccessToken:')
      console.log(accessToken)

      const result = await fetch(ConfApi, {
        method: 'GET',
        headers: {
          Authorization: 'Bearer ' + accessToken
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
