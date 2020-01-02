require('dotenv').config();

export default {
  mode: 'spa',

  /*
  ** Headers of the page
  */
  head: {
    title: 'Moladin Affliate',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: 'Moladin Affliate Tools' },
      { name: 'robots', content: 'noindex' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.png' }
    ],
    script: [
      {
        src: '/popper/dist/umd/popper.min.js'
      }
    ]
  },

  server: {
      port: process.env.PORT,
      host: process.env.IP
  },

  /*
  ** Customize the progress-bar color
  */
 loading: '~/components/Loading',

  /*
  ** Global CSS
  */
  css: [
    { src: '~/assets/plugins/admin-lte/scss/AdminLTE.scss', lang: 'scss' },
    { src: '~/assets/scss/main.scss', lang: 'scss' },
    { src: 'font-awesome/scss/font-awesome.scss', lang: 'scss' },
    { src: '~/assets/css/vue-select.css', lang: 'css' },
    { src: '~/assets/css/dataTables.bootstrap4.min.css', lang: 'css' },
  ],

  /*
  ** Plugins to load before mounting the App
  */
  plugins: [
    { src: '~/plugins/jquery.min.js', ssr: false },
    { src: '~/plugins/bootstrap.min.js', ssr: false },
    { src: '~/plugins/jquery.dataTables.min.js', ssr: false },
    { src: '~/plugins/dataTables.bootstrap4.min.js', ssr: false },
    { src: '~/plugins/sweetalert.js', ssr: false },
    { src: '~/plugins/vue-multiselect.js', ssr: false }
  ],

  axios: {
    baseURL: process.env.BASE_URL,
    proxyHeaders: false,
    credentials: false
  },

  auth: {
    redirect: {
      login: '/',
      logout: '/',
      callback: '/',
      home: '/dashboard/affliasi'
    },
    strategies: {
      local: {
        endpoints: {
          login: { url: '/auth/login', method: 'post', propertyName: 'result.token' },
          logout: { url: '/auth/logout', method: 'post' },
          user: { url: '/auth/me', method: 'get', propertyName: 'result' }
        }
      }
    }
  },

  /*
  ** Nuxt.js modules
  */
  modules: [
    '@nuxtjs/axios',
    '@nuxtjs/auth',
    '@nuxtjs/dotenv',
    ['@nuxtjs/date-fns', {
      locale: 'id'
    }]
  ],

  /*
  ** Build configuration
  */
  build: {
    /*
    ** You can extend webpack config here
    */
    extend(config, ctx) {
    }
  }
}
