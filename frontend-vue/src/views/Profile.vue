<template>
  <div>
    <div>
      <img :src="userImage" />
      <h2>{{ $auth.user.name }}</h2>
      <p>{{ $auth.user.email }}</p>
    </div>

    <div>
      <pre>{{ JSON.stringify($auth.user, null, 2) }}</pre>
    </div>
  </div>
</template>

<script>

export default {
  name: 'profile-view',
  components: {
  },
  computed: {
    userImage () {
      console.log(this.$auth.user.picture)
      if (this.$auth.user.picture) {
        return this.$auth.user.picture
      } else {
        return 'https://via.placeholder.com/150'
      }
    }
  }
}
</script>
