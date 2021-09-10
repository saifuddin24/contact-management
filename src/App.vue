<template>
  <div id="nav">
        <router-link to="/">Home</router-link> |
        <router-link to="/group">Group</router-link> |

        <router-link v-if="!$store.state.isLoggedIn" to="/login">Login</router-link>
        <span v-else>
            {{userName}}
        </span>

  </div>

  <router-view/>
</template>

<script>
    export  default {
        computed: {
            userName() {
                const userData = this.$store.state.user;
                return userData ? userData.name : '';
            }
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

    #nav {
      padding: 30px;
    }

    #nav a {
      font-weight: bold;
      color: #2c3e50;
    }

    #nav a.router-link-exact-active {
      color: #42b983;
    }

    .home {
        border: 1px solid red;
        text-align: center;
    }

</style>
