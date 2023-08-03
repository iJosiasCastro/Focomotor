<template>
  <div>
    <div v-if="errorMessage" class="text-lg flex p-4 mb-4 text-red-700 bg-red-200 rounded-lg" role="alert">
      <svg class="inline flex-shrink-0 mr-3 w-6 h-6 my-auto" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
      <div>
        <span class="font-medium">{{errorMessage}}</span>
      </div>
    </div>

    <!-- Email -->
    <div v-show="step==1">

        <div class="text-left">
            <button @click="$emit('close')" class="text-primary flex items-center">
                <i class="text-2xl fas fa-arrow-left mr-2"></i>
                <span>
                Atrás
                </span>
            </button>
            <div class="h-4"></div>
        </div>

        <form @submit.prevent="checkUserExist()">
            <PartialsFormInput @clearError="errors.email = null" v-model="user.email" type="email"  name="email" label="Ingresá tu email" placeholder="Email"
                :required="true" :errors="errors" tag="input" />

            <div class="flex justify-center -mt-4">
                <button type="submit" class="bg-primary w-full duration-500 hover:opacity-75 opacity-100 px-5 py-2 rounded-lg text-white transition-opacity">Continuar</button> 
            </div>
        </form>
    </div>

    <!-- Register -->
    <div v-show="step==2 && userExist">
        <div class="text-left">
            <button @click="step=1" class="text-primary flex items-center">
                <i class="text-2xl fas fa-arrow-left mr-2"></i>
                <span>
                {{user.email}}
                </span>
            </button>
            <div class="h-6"></div>
        </div>

        <form @submit.prevent="register()">
            <div class="text-left mb-2">
              <h5 class="text-2xl">
                Bienvenido
              </h5>
            </div>
            <PartialsFormInput v-model="user.password" :type="seePassword" name="password" label="Creá tu contraseña para continuar" placeholder="Contraseña"
                :required="true" :errors="errors" tag="input" @clearError="errors.password = null" >
                <template #append>
                  <span class="inline-flex items-center px-3 text text-gray-900 bg-gray-200 rounded-r-md border border-l-0 border-gray-300">
                      <button type="button" @click="seePassword=='password' ? seePassword='text' : seePassword='password'">
                          <i class="fas fa-eye" v-show="seePassword=='password'"></i>
                          <i class="fas fa-eye-slash" v-show="seePassword=='text'"></i>
                      </button>
                  </span>
                </template>
            </PartialsFormInput>

            <div class="flex justify-center -mt-4">
                <button type="submit" class="bg-primary w-full duration-500 hover:opacity-75 opacity-100 px-5 py-2 rounded-lg text-white transition-opacity">Registrarme</button> 
            </div>
        </form>
    </div>

    <!-- Login -->
    <div v-show="step==2 && !userExist">
        <div class="text-left">
            <button @click="step=1" class="text-primary flex items-center">
                <i class="text-2xl fas fa-arrow-left mr-2"></i>
                <span>
                Atrás
                </span>
            </button>
            <div class="h-6"></div>
        </div>

        <form @submit.prevent="login()">
            <div class="text-left mb-2">
              <h5 class="text-2xl">
                ¡Hola de nuevo!
              </h5>
            </div>
            <PartialsFormInput v-model="user.password" :type="seePassword" name="password" label="Ingresá tu contraseña para continuar" placeholder="Contraseña"
                :required="true" :errors="errors" tag="input" @clearError="errors.password = null" >
                <template #append>
                  <span class="inline-flex items-center px-3 text text-gray-900 bg-gray-200 rounded-r-md border border-l-0 border-gray-300">
                      <button type="button" @click="seePassword=='password' ? seePassword='text' : seePassword='password'">
                          <i class="fas fa-eye" v-show="seePassword=='password'"></i>
                          <i class="fas fa-eye-slash" v-show="seePassword=='text'"></i>
                      </button>
                  </span>
                </template>
            </PartialsFormInput>
              
            <div class="flex justify-center -mt-4">
                <button type="submit" class="bg-primary w-full duration-500 hover:opacity-75 opacity-100 px-5 py-2 rounded-lg text-white transition-opacity">Ingresar</button> 
            </div>

            <div class="mt-4">
              <NuxtLink :to="{name:'user.resetPassword'}" class="text-gray-600 hover:text-gray-800 text-base">
                Olvidé mi contraseña
              </NuxtLink>
            </div>
        </form>
    </div>

  </div>

</template>

<script>
export default {
  props: ['redirectName'],
  data(){
    return{
      user:{
        email: '',
        password: ''
      },
      seePassword: 'password',
      userExist: '',
      step: 1,
      errors: {},
      errorMessage: ''
    }
  },
  methods: {
    async checkUserExist(){
      this.$axios.$post('auth/exist', { email: this.user.email })
        .then(res => {
          if(res=='google'){
            window.location.href = this.$axios.defaults.baseURL+'google-login'
          }else{
            this.userExist = res
            this.step=2
          }
        })
        .catch((err)=>{
          this.errors = '';
          if(err.response.data){
              this.errors = err.response.data.errors
          }else{
              console.error(err)
          }
        })

    },
    async login() {
      this.$auth.loginWith('laravelJWT', { data: this.user })
        .then(res => {
          this.$router.push({name: this.redirectName})
        })
        .catch((err)=>{
          if(err.response.data){
              this.errorMessage = err.response.data.message
          }else{
              console.error(err)
          }
        })
    },
    async register() {
      this.$axios.post('auth/register', this.user)
      .then(res => {
        this.$auth.loginWith('laravelJWT', { data: {token: res.data }})
          .then(res => {
              this.$router.push({name: this.redirectName})
          })
      })
      .catch(err => {
          this.errors = '';
          window.scrollTo(0, 0)

          if(err.response.data.errors){
              this.errors = err.response.data.errors
          }else{
              console.error(err)
          }
      })
    },
  }
}
</script>


<style>
#password{
    border-top-right-radius: 0% !important;
    border-bottom-right-radius: 0% !important;
}
</style>