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
              <p class="text-white">Sudah Punya Akun ?
                <nuxt-link class="text-warning" to="/">Login</nuxt-link>
              </p>
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
    head() {
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
      // if (this.$auth.$state.loggedIn) {
      //   return this.$router.go('/dashboard/affliasi')
      // }

      let cookie = getCookie('affliasi');

      if (cookie != "" && cookie != null) {
        const json = JSON.parse(cookie);
        let data = {
          transaction_id: json.transaction_id,
          campaign: json.campaign,
          total: 5000000,
          komisi: 500000
        }

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            console.log('affliate program success');
            // document.cookie = "affliasi= ; expires = Thu, 01 Jan 1970 00:00:00 GMT"
          }
        }

        xhttp.open("POST", 'https://affliasi.test/api/transaction/callback');
        xhttp.setRequestHeader("Content-type", "application/json");
        xhttp.send(JSON.stringify(data));

      }

      // checkCookie();

      function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
      }

      function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i = 0; i < ca.length; i++) {
          var c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
      }

      function checkCookie() {
        var urlParams = new URLSearchParams(window.location.search);

        if (urlParams.has('type') && urlParams.has('transaction_id') && urlParams.has('campaign')) {
          var data = {
            transaction_id: urlParams.get('transaction_id'),
            campaign: urlParams.get('campaign')
          }

          setCookie('affliasi', JSON.stringify(data), 30);
        }
      }


    },
  }
</script>
