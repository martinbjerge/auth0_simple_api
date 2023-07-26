<template>
  <b-navbar type="dark" variant="primary" toggleable="sm">
    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav>
        <b-nav-item :to="{ path: '/' }">Home</b-nav-item>
        <b-nav-item v-if="$auth.isAuthenticated" :to="{ path: '/profile' }">Profile</b-nav-item>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>

<script>
export default {
  name: 'NavBar',
  props: {
    msg: String
  }
}
</script>

  <!-- Add "scoped" attribute to limit CSS to this component only -->
  <style scoped>
  li {
    display: inline-block;
    margin: 0 10px;
  }
  nav {
    padding: 20px;
  }
  a {
    color: #ffffff;
  }
  nav a.router-link-exact-active {
    color: #000000;
  }
  </style>
