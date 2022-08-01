<template>
    <div class="card">
        <form @submit.prevent="send()" class="card-body">

            <div class="form-group">
                <label>Nombre</label>
                <input required v-model="message.name" type="text" class="form-control" placeholder="Enter a name">
                <div class="alert alert-danger" v-if="errors.name">{{errors.name[0]}}</div>
            </div>

            <div class="form-group">
                <label>Email o teléfono</label>
                <input required v-model="message.contact" type="text" class="form-control" placeholder="Enter a contact">
                <div class="alert alert-danger" v-if="errors.contact">{{errors.contact[0]}}</div>
            </div>

            <div class="form-group">
                <label>Mensaje</label>
                <textarea required rows="3" class="form-control" v-model="message.message" placeholder="Enter a messagge"></textarea>
                <div class="alert alert-danger" v-if="errors.message">{{errors.message[0]}}</div>
            </div>

            <div class="">
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>

        </form>
    </div>
</template>

<script>
export default {
    props:['vehicle'],
    data(){
        return {
            message:{
                name: '',
                contact: '',
                message: ''
            },
            errors: {}
        }
    },
    methods:{
        send(){
            this.$axios.$post(`message/${this.vehicle}`, this.message)
                .then(res => {
                    // console.log('El mensaje fue envíado con éxito')
                    // console.log(res)
                })
                .catch(err => {
                    this.errors = ''
                    if(err.response.data.errors){
                        // console.log(err.response.data)
                        this.errors = err.response.data.errors
                    }else{
                        // console.log(err.response)
                        console.error(err)
                    }
                })

        }
    }
}
</script>