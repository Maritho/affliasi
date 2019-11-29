<template>
  <div class="login-box">
    <div class="card">
      <div class="card-body login-card-body">
        <div class="row">
          <div class="col-md-6 vertical-center">
            <img src="https://moladin.com/images/moladin-logo-nav.png" class="img-fluid" alt="Moladin.com">
          </div>
          <div class="col-md-6">
            <p class="login-box-msg">Welcome, Please Sign in</p>
            <div v-if="error !== null" class="alert alert-warning alert-dismissible fade show" role="alert">
              {{error}}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="post" @submit.prevent="login">
              <div class="input-group mb-3">
                <div class="input-group-append">
                    <span class="fa fa-user input-group-text"></span>
                </div>
                <input type="text" v-model="username" class="form-control" placeholder="Username">
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append">
                    <span class="fa fa-lock input-group-text"></span>
                </div>
                <input type="password" v-model="password" class="form-control" placeholder="Password">
              </div>
              <button class="btn btn-block btn-pln-default">
                Masuk
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  middleware: ['auth'],
  layout: 'blank', 
  head () {
    return {
      bodyAttrs: {
        class: 'hold-transition login-page'
      }
    }
  },
  data() {
    return {
      username: '',
      password: '',
      device_id: 'web',
      error: null
    }
  },
  
  methods: {
    async login() {
      try {
        await this.$auth.loginWith('local', {
          data: {
            username: this.username,
            password: this.password,
            device_id: this.device_id
          }
        })
        this.$router.push('/dashboard/dana-tunai/pooling')
      } catch (e) {
        this.error = e.response.data.message
      }
    }
  },

  mounted(redirect) {
    if (this.$auth.$state.loggedIn) {
      return this.$router.go('/dashboard/dana-tunai/pooling')
    }
  },
}
</script>