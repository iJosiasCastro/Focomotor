import routes from './routes.js'
export default {
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: 'Focomotor',
    htmlAttrs: {
      lang: 'en'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' },
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' },
      // { rel:'stylesheet', href: 'https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css'},      
      { rel: "stylesheet", href: "/flowbite.min.css" },
      { rel:'stylesheet', href: '/tailwind.min.css'},      
      { rel: "stylesheet", href: "/styles.css" },
    ],
    script: [
      {src: 'https://kit.fontawesome.com/252250494d.js', async: true, crossorigin: 'anonymous'},
      { src: '/flowbite.js' },
    ],
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    // { src: '~/plugins/infiniteloading', ssr: false },
    { src: '~/plugins/vue-picture-swipe', ssr: false },
    { src: '~/plugins/directives', ssr: false },
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    'vue-ssr-carousel/nuxt',
    '@nuxtjs/pwa',
  ],
  

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios',
    '@nuxtjs/auth-next',
    '@nuxtjs/moment'
  ],

  moment: {
    timezone: true
  },

  pwa: {
    manifest: {
      name: 'Focomotor',
      short_name: 'Focomotor',
      description: 'Tu lugar para comprar y vender vehículos',
      lang: 'es',
      useWebmanifestExtension: false,
      start_url: '/',
      display: 'fullscreen'
    },
    icon: {
      purpose: 'maskable'
    }
  },


  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    // Workaround to avoid enforcing hard-coded localhost:3000: https://github.com/nuxt-community/axios-module/issues/308
    browserBaseURL: process.env.APP_URL+'api/',
    baseURL: process.env.APP_URL+'api/',
    headers: {
      common: {
        Accept: 'application/json'
      }
    },
    // proxy: true
  },

  proxy: {
    '/api/': process.env.APP_URL+'api/',  
    '/laravel': {
      target: 'https://api.focomotor.com.ar/',
      // target: 'http://192.168.0.186/',
      pathRewrite: { '^/laravel': '/' }
    }
  },

  auth: {
    strategies: {
      'laravelJWT': {
        provider: 'laravel/jwt',
        url:  'https://api.focomotor.com.ar',
        // url: 'http://192.168.0.186:8080',
        token: {
          property: 'access_token',
          maxAge: 60 * 60
        },
        refreshToken: {
          maxAge: 20160 * 60
        },
      },
    },
    redirect: {
      login: '/ingresar',
      home: '/mis-vehiculos',
      logout: '/'
    },
  },
  
  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  },
  // server: {
  //     port: 8000,
  //     host: "0.0.0.0"
  // },
  server: {
    port: 3001
  },

  router: {
    ...routes,
    middleware: 'redirectStandalone'
    
  },
  
}