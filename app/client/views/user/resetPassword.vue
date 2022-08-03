<template>
<App>
  <PartialsTitle title="Restablecer contraseña" background_num="9" />
  <div class="max-w-xl mx-auto px-2">
    <div class="h-10 lg:h-16"></div>

    <div>
      <div class="text-lg bg-gray-100 border border-gray-400 border-solid p-3 rounded-lg shadow-lg text-center py-8">

        <div v-if="error || message" class="max-w-md text-lg mb-10 mx-auto">
          <div class="flex p-4 mb-4  rounded-lg" role="alert" :class="error ? 'text-red-700 bg-red-200' : 'text-green-700 bg-green-200'">
            <svg v-show="error" class="inline flex-shrink-0 mr-3 w-6 h-6 my-auto" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
            <i v-show="!error" class="fa-check fas mr-3 my-auto"></i>

            <div>
              <span class="font-medium">{{error ? error.message : message}}</span>
            </div>
          </div>
        </div>

        <form @submit.prevent="sendEmail()" v-if="!token">
          
          <div class="h-2"></div>
          <div class="text-xl max-w-md mx-auto text-center">
            <h3>Te enviaremos un link a tu email para restablecer tu contraseña.</h3>
          </div>

          <div class="max-w-sm mx-auto my-8">
            <PartialsFormInput v-model="user.email" type="email"  name="email" label="Email" placeholder="Ingresá tu email"
              :required="true" :errors="error" tag="input" />

            <div class="h-2"></div>

            <div class="flex justify-center">
              <button :disabled="sending" type="submit" class="flex justify-center items-center w-full text-lg bg-primary duration-500 hover:opacity-75 opacity-100 px-3 py-2 rounded-lg text-white transition-opacity">
                  <svg v-show="sending" role="status" class="w-4 h-4 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                      <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                  </svg>
                  {{ sending ? 'Enviando' : 'Enviar correo de recuperación' }}
              </button>
            </div>
          </div>


        </form>
        <div v-else>
          <form @submit.prevent="resetPassword()" v-if="!message">

            <div class="max-w-sm mx-auto my-4">
              <PartialsFormInput v-model="user.password" :type="seePassword" name="password" label="Ingresá una nueva contraseña para continuar" placeholder="Contraseña"
                :required="true" :errors="error" tag="input" >
                <template #append>
                  <span class="inline-flex items-center px-3 text text-gray-900 bg-gray-200 rounded-r-md border border-l-0 border-gray-300">
                      <button type="button" @click="seePassword=='password' ? seePassword='text' : seePassword='password'">
                          <i class="fas fa-eye" v-show="seePassword=='password'"></i>
                          <i class="fas fa-eye-slash" v-show="seePassword=='text'"></i>
                      </button>
                  </span>
                </template>
              </PartialsFormInput>

              <div class="flex justify-center -mt-2">
                <button type="submit" class="flex justify-center items-center w-full text-lg bg-primary duration-500 hover:opacity-75 opacity-100 px-3 py-2 rounded-lg text-white transition-opacity">
                  Continuar
                </button>
              </div>
            </div>

          </form>
          <div v-else class="max-w-sm mx-auto">
            <div class="text-xl max-w-md mx-auto text-center">
              <h3>Para ir a tu cuenta debes ingresar</h3>
            </div>
            <div class="h-2"></div>
            <div class="my-4">
              <NuxtLink :to="{name: 'user.login'}" class="flex justify-center items-center w-full text-lg bg-primary duration-500 hover:opacity-75 opacity-100 px-3 py-2 rounded-lg text-white transition-opacity">
                  {{ 'Ingresar' }}
              </NuxtLink>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</App>
</template>

<script>
export default {
  middleware: 'guest',
  head(){
    return {
        title: 'Restablecer contraseña - Focomotor'
    }
  },
  asyncData({query}){
    return {token: query.token, email: query.email}
  },
  data(){
    return{
      seePassword: 'password',
      user: {
        email: '',
        password: ''
      },
      sending: false,
      error: null,
      message: null
    }
  },
  methods: {
    sendEmail() {
      this.sending = true
      this.$axios.$post('auth/reset_password_without_token', this.user)
        .then(res => {
          // console.log(res)
          this.user.email = ''
          this.error = null
          this.message = res.message
        })
        .catch((err)=>{
          // console.log(err)
          this.errors = '';
          if(err.response.data){
              this.error = err.response.data
          }else{
              console.error(err)
          }
        })
        .finally(()=>{
          this.sending = false
        })
    },
    resetPassword(){
      // console.log(this.$route.query)
      this.$axios.$post('auth/reset_password_with_token', {...this.user, ...this.$route.query})
        .then(res => {
          // console.log(res)
          this.user.email = ''
          this.error = null
          this.message = res.message
        })
        .catch((err)=>{
          // console.log(err)
          this.errors = '';
          if(err.response.data){
              this.error = err.response.data
          }else{
              console.error(err)
          }
        })
        .finally(() => {
          this.sending = false
        })
    }
  }
}
</script>