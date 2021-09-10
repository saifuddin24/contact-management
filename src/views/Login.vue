<template>
  <div class="login">

    <div>

      <h1>Login</h1>
      <form class="form login-form" action="" method="post" @submit.prevent="submitLogin">

        <div class="input-item">
          <label for="username" >Username</label>
          <input type="text" v-model="userdata.email" id="username">
        </div>

        <div class="input-item">
          <label for="password">Password</label>
          <input type="password"   v-model="userdata.password" id="password">
        </div>

        <div class="input-item">
          <button type="submit" class="btn" >Login</button>
        </div>



      </form>
    </div>
  </div>
</template>

<script>

  export default {
    components: {

    },
    data(){
      return {
        userdata: {
          email: '',
          password: ''
        }
      }
    },
    methods: {
      submitLogin(){

        this.$store.dispatch( 'login', {
          data: this.userdata,
          success: () => {
            this.$router.push('/')
          }
        })

      }
    }

  }

</script>

<style >

    .login {
      display: flex;
      justify-content: center;
    }

    .form {
      text-align: left;
    }

    .login-form {
      width: 400px;
    }

    .input-item {
      margin-bottom: 10px;
    }

    .login .input-item input {
      width: 100%;
      padding: 8px 10px;
    }

    .btn {
      padding: 10px 20px;
      background: #2c3e50;
      color: #FFF;
      cursor: pointer;
    }


    .input-item label {
      display: block;
    }

</style>
