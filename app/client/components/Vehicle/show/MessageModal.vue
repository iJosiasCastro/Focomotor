<template>
<div>
    <PartialsModal :show="show" @close="$emit('close')">
        <form @submit.prevent="submit()" class="max-w-md mx-auto">
            <h3 class="mb-5 text-xl font-normal text-gray-800 my-4">Enviar mensaje al vendedor</h3>

            <div class="text-lg mb-10 mx-auto mt-8" v-if="send">
                <div class="flex justify-center p-4 mb-4 text-green-700 bg-green-200 rounded-lg" role="alert">
                    <i class="fa-check fas mr-3 my-auto"></i>
                    <div>
                    <span class="font-medium">Tu mensaje fue enviado</span>
                    </div>
                </div>
            </div>
            <div v-else>


                <PartialsFormInput v-model="form.name" type="text"  name="name" label="Tu nombre" placeholder="Ingresá tu nombre"
                    :required="true" :errors="errors" tag="input" @clearError="errors.name = null; send = false" />

                <PartialsFormInput v-model="form.contact" type="text"  name="contact" label="Tu contacto" placeholder="Ingresá tu email o teléfono"
                    :required="true" :errors="errors" tag="input" @clearError="errors.contact = null; send = false" />

                <PartialsFormInput v-model="form.message" :rows="4" type="textarea"  name="message" label="Mensaje" placeholder="Ingresá tu mensaje"
                    :required="true" :errors="errors" tag="textarea" @clearError="errors.message = null; send = false" />

                <button :disabled="sending" type="submit" class="flex justify-center items-center w-full text-lg bg-primary duration-500 hover:opacity-75 opacity-100 px-3 py-2 rounded-lg text-white transition-opacity">
                    <svg v-show="sending" role="status" class="w-4 h-4 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    {{ sending ? 'Enviando' : 'Enviar' }}
                </button>
            </div>
        </form>
    </PartialsModal>
</div>

</template>

<script>
export default {
    props:['vehicleSlug', 'show'],
    mounted(){
        let user = this.$store.state.auth.user
        // console.log(user)
        if(user){
            this.form.name = user.name
            if(user.whatsapp){
                this.form.contact = user.whatsapp
            }else{
                this.form.contact = user.email
            }
        }
    },
    data(){
        return{
            form: {
                name: '',
                contact: '',
                message: 'Hola. ¿Sigue disponible?'
            },
            send: false,
            sending: false,
            errors: {}
        }
    },
    methods:{
        submit(){
            this.sending = true
            this.$axios.post(`message/${this.vehicleSlug}`, this.form)
                .then(res => {
                    // console.log(res)
                    window.scrollTo(0, 0)
                    this.send = true
                    this.form = {
                        name: '',
                        contact: '',
                        message: 'Hola. ¿Sigue disponible?'
                    }
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
        }
    }
}
</script>