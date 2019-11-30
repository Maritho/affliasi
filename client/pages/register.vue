<template>
  <div class="login-box">
    <div class="card">
      <div class="card-body login-card-body">
        <div class="row">
          <div class="col-md-6 vertical-center">
            <img src="https://moladin.com/images/moladin-logo-nav.png" class="img-fluid" alt="Moladin.com">
          </div>
          <div class="col-md-6">
            <p class="login-box-msg">Pendaftaran</p>
            <div v-if="error !== null" class="alert alert-warning alert-dismissible fade show" role="alert">
              {{error}}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form method="post" @submit.prevent="login">
              <div class="input-group mb-3">
                <div class="input-group-append blank">
                    <span class="fa fa-user input-group-text"></span>
                </div>
                <input type="text" v-model="name" class="form-control" placeholder="Nama Lengkap">
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append blank">
                  <span class="fa fa-envelope input-group-text"></span>
                </div>
                <input type="text" v-model="email" class="form-control" placeholder="Email">
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append blank">
                  <span class="fa fa-phone input-group-text"></span>
                </div>
                <input type="text" v-model="phone" class="form-control" placeholder="Nomor Telepone">
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append blank">
                  <span class="fa fa-globe input-group-text"></span>
                </div>
                <input type="url" v-model="url_blog" class="form-control" placeholder="URL Blog">
              </div>
              <div class="input-group mb-3">
                <div class="input-group-append blank">
                    <span class="fa fa-lock input-group-text"></span>
                </div>
                <input type="password" v-model="password" class="form-control" placeholder="Password">
              </div>
              <p class="text-white">Sudah Punya Akun ? <nuxt-link class="text-warning" to="/">Login</nuxt-link></p>
              <button class="btn btn-block btn-pln-default">
                Daftar
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
      name: '',
      email: '',
      phone: '',
      url_blog: '',
      password: '',
      error: null
    }
  },

  methods: {
    async login() {
      try {
        await this.$axios.$post('/auth/register', {
          name: this.name,
          email: this.email,
          phone: this.phone,
          url_blog: this.url_blog,
          password: this.password,
        }).then(response => {
          if (response.status) {
            this.$swal('Sukses', 'Pendaftaran Berhasil', 'success')
            this.$router.push('/')
          } else {
            this.error = response.message
          }
        })
      } catch (e) {
        this.error = e.response.data.message
      }
    }
  },

  mounted(redirect) {
    if (this.$auth.$state.loggedIn) {
      return this.$router.go('/dashboard/affliasi')
    }
  },
}
</script>
