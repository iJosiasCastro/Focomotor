<template>
  <App>
    <PartialsTitle :title="`Plan ${$route.params.slug}`" background_num="7" />
    <div class="h-5"></div>
    <section class="max-w-xl mx-auto px-2">
        <div class="h-5 md:h-8"></div>

        <div v-if="message" class="max-w-md text-lg mb-10 mx-auto">
            <PartialsSubtitle subtitle="¡Gracias! Te enviaremos un link de pago. Al acreditar tu suscripción, habilitaremos tu cuenta de email con el plan elegido." />
            <div class="h-6"></div>
            <NuxtLink :to="{ name:'home' }" class="bg-primary duration-500 hover:opacity-75 opacity-100 px-5 py-2 rounded-lg text-white transition-opacity">
                Volver a navegar
            </NuxtLink> 
        </div>
        <form v-else @submit.prevent="sendEmail()">
            <PartialsSubtitle subtitle="Llená este formulario para continuar" />

            <div class="h-8 md:h-12"></div>
            <PartialsFormInput v-model="form.concessionaire_name" type="text" name="concessionaire_name" label="Nombre de la concesionaria" placeholder="Ingresá el nombre de la concesionaria"
                    :required="true" :errors="errors" @clearError="errors.concessionaire_name = null" tag="input" />

            <PartialsFormInput v-model="form.name" type="text" name="name" label="Tu nombre" placeholder="Ingresá tu nombre"
                    :required="true" :errors="errors" @clearError="errors.name = null" tag="input" />


            <PartialsFormInput v-model="form.email" type="email" name="email" label="Correo electrónico" placeholder="Ingresá tu correo electrónico"
                :required="true" :errors="errors" @clearError="errors.email = null" tag="input" />

            <PartialsFormInput v-model="form.phone" type="tel" name="phone" label="Celular" placeholder="Ingresá tu número de celular"
                :required="true" :errors="errors" @clearError="errors.phone = null" tag="input" />

            <PartialsFormInput v-model="form.city" type="text" name="city" label="Ciudad" placeholder="Ingresá tu ciudad"
                :required="true" :errors="errors" @clearError="errors.city = null" tag="input" />

            <div class="h-6"></div>
            <button :disabled="sending" type="submit" class="flex justify-center items-center w-full text-lg bg-primary duration-500 hover:opacity-75 opacity-100 px-3 py-2 rounded-lg text-white transition-opacity">
                <svg v-show="sending" role="status" class="w-4 h-4 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
                {{ sending ? 'Enviando' : 'Enviar' }}
            </button>
        </form>
    </section>
  </App>
</template>

<script>
export default {
  head() {
    return {
      title: "Plan " + this.$route.params.slug + " - Focomotor",
    };
  },
  data(){
    return {
        form: {
            concessionaire_name: '',
            name: '',
            email: '',
            phone: '',
            city: '',
            plan: this.$route.params.slug,
        },
        errors:{},
        sending: false,
        message: null

    }
  },
  methods:{
    sendEmail() {
      this.sending = true
      this.$axios.$post('email/plan', this.form)
        .then(res => {
          // console.log(res)
          this.errors = null
          this.message = res
        })
        .catch(err => {
            this.errors = {}
            if(err.response.data.errors){
                // console.log(err.response.data)
                window.scrollTo(0, 0)
                this.errors = err.response.data.errors

            }else{
                // console.log(err.response)
                console.error(err)
            }
        })
        .finally(() => {
          this.sending = false
        })
    },
  }

};
</script>