<template>
<div id="app">
  <b-container fluid>
    <b-row>
      <NavBar/>
    </b-row>
    <b-row>
      <div class="pt-2">
        <!--<error />-->
        <div class="mt-2">
          <router-view />
        </div>
      </div>
    </b-row>
  </b-container>
  <FooterBar/>
</div>
</template>

<script>
import NavBar from './components/NavBar.vue'
import FooterBar from './components/FooterBar.vue'

export default {
  name: 'App',
  components: {
    NavBar,
    FooterBar
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
body {
    padding-bottom: 80px;
}
</style>
