export default {
    extendRoutes(routes, resolve) {
      return [
        {
          name: 'home',
          path: '/',
          component: resolve(__dirname, 'views/home.vue')
        },
        {
          name: 'vehicle.index',
          path: '/listado',
          component: resolve(__dirname, 'views/vehicle/index.vue')
        },
        {
            name: 'vehicle.show',
            path: '/vehiculos/:slug',
            component: resolve(__dirname, 'views/vehicle/show.vue')
        },

        {
          name: 'vehicle.create',
          path: '/publicar',
          component: resolve(__dirname, 'views/vehicle/create.vue')
        },

        // Author
        {
          name: 'vehicle.author',
          path: '/autor/:slug',
          component: resolve(__dirname, 'views/vehicle/author.vue')
        },
        
        
        // User
          // Vehicle
        {
          name: 'user.dashboard',
          path: '/mis-vehiculos',
          component: resolve(__dirname, 'views/user/dashboard.vue'),
        },
        {
          name: 'vehicle.edit',
          path: '/mis-vehiculos/editar/:slug',
          component: resolve(__dirname, 'views/vehicle/edit.vue'),
        },

          // Login
        {
          name: 'user.login',
          path: '/ingresar',
          component: resolve(__dirname, 'views/user/login.vue')
        },
        {
          name: 'user.register',
          path: '/registrarse',
          component: resolve(__dirname, 'views/user/register.vue')
        },
        {
          name: 'user.edit',
          path: '/usuario/editar',
          component: resolve(__dirname, 'views/user/edit.vue')
        },
        {
          name: 'user.resetPassword',
          path: '/restablecer',
          component: resolve(__dirname, 'views/user/resetPassword.vue')
        },
        {
          name: 'google-login',
          path: '/google-login',
          component: resolve(__dirname, 'views/user/googleLogin.vue')
        },
        {
          name: 'info.terms',
          path: '/terminos-y-condiciones',
          component: resolve(__dirname, 'views/info/terms.vue')
        },
        {
          name: 'info.policy',
          path: '/politica-de-privacidad',
          component: resolve(__dirname, 'views/info/policy.vue')
        },
        {
          name: 'info.contact',
          path: '/contacto',
          component: resolve(__dirname, 'views/info/contact.vue')
        },

        // Plan
        {
          name: 'plan.index',
          path: '/planes',
          component: resolve(__dirname, 'views/plan/index.vue')
        },
        {
          name: 'plan.show',
          path: '/planes/:slug',
          component: resolve(__dirname, 'views/plan/show.vue')
        },

        {
          path: '/vehiculos',
          redirect: '/listado',
        }
      
      ]
    }
}