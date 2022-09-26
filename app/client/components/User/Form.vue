<template>
    <div>
        <div v-if="!isEmptyErrors" class="text-lg mb-10 mx-auto">
            <div class="flex p-4 mb-4 text-red-700 bg-red-200 rounded-lg" role="alert">
                <svg class="inline flex-shrink-0 mr-3 w-6 h-6 my-auto" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <div>
                <span class="font-medium">Hay campos que se deben corregir</span>
                </div>
            </div>
        </div>
        <form @submit.prevent="submit()">

            <PartialsFormInput v-model="user.name" type="text" name="name" label="Nombre" placeholder="Ingresá tu nombre"
                :required="true" :errors="errors" @clearError="errors.name = null" tag="input" />

            <PartialsFormInput :disabled="true" :extraClasses="'opacity-75'" v-model="user.email" type="email" name="email" label="Correo electrónico" placeholder="Ingresá tu correo electrónico"
                :required="true" :errors="errors" @clearError="errors.email = null" tag="input" />

            <PartialsFormInput v-if="!editable" v-model="user.password" type="password" name="password" label="Contraseña" placeholder="Ingresá tu contraseña"
                :required="true" :errors="errors" @clearError="errors.password = null" tag="input" />
            
            <PartialsFormInput v-model="user.whatsapp" type="tel" name="whatsapp" label="Whatsapp (Opcional)" placeholder="Ingresá tu número de Whatsapp"
                :errors="errors" @clearError="errors.whatsapp = null" tag="input" >
                <template #preappend>
                    <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 rounded-l-md border border-r-0 border-gray-300">
                        +54
                    </span>
                </template>
                <template #information>
                    <p class="mt-2 text-sm text-gray-600">Con codigo de area</p>
                </template>
            </PartialsFormInput>

            <PartialsFormInput v-model="user.phone" type="tel" name="phone" label="Teléfono (Opcional)" placeholder="Ingresá tu número de teléfono"
                :errors="errors" @clearError="errors.phone = null" tag="input" >
                <template #preappend>
                    <span class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 rounded-l-md border border-r-0 border-gray-300">
                        +54
                    </span>
                </template>
                <template #information>
                    <p class="mt-2 text-sm text-gray-600">Con codigo de area</p>
                </template>
            </PartialsFormInput>

            <PartialsFormInput name="state_id" label="Provincia" :errors="errors" @clearError="errors.state_id = null" >
                <select required @change="e=>selectState(e.target.value)" v-model="user.state_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Selecciona una provincia</option>
                    <option v-for="state in data.states" :key="state.id" :value="state.id">{{state.name}}</option>
                </select>
            </PartialsFormInput>

            <PartialsFormInput v-if="data.districts.length" name="district_id" label="Partido" :errors="errors" @clearError="errors.district_id = null" >
                <select required @change="e=>selectDistrict(e.target.value)" v-model="user.district_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Selecciona un partido</option>
                    <option v-for="district in data.districts" :key="district.id" :value="district.id">{{district.name}}</option>
                </select>
            </PartialsFormInput>

            <PartialsFormInput v-if="data.cities.length" name="city_id" label="Ciudad" :errors="errors" @clearError="errors.city_id = null" >
                <select required @change="e=>user.city_id=e.target.value" :value="user.city_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Selecciona una ciudad</option>
                    <option v-for="city in data.cities" :key="city.id" :value="city.id">{{city.name}}</option>
                </select>
            </PartialsFormInput>

            <button type="submit" class="w-full text-lg bg-primary duration-500 hover:opacity-75 opacity-100 px-3 py-2 rounded-lg text-white transition-opacity">
                {{ editable ? 'Editar' : 'Registrarse' }}
            </button>

        </form>

    </div>
</template>

<script>
export default {
    props: ['redirectName', 'editable'],
    async fetch(){
        this.data.states = await this.$axios.$get('states')
        // Replace null values for '' and save in this.user 
        for (const key in this.editable) {
            if(this.editable[key] == null){
                this.user[key] = ''
            }else{
                this.user[key] = this.editable[key] 
            }
        }

        // Get locations data
        if(this.editable.state_id){
            const state = await this.$axios.$get(`states/${this.user.state_id}`)
            if(state.type == 'cities'){
                this.data.cities = state.data
            }else if(state.type == 'districts'){
                this.data.districts = state.data
                if(this.editable.city_id){
                    const district = this.data.districts.find(i=>i.id == this.editable.district_id)
                    this.data.cities = district.cities
                }
            }
        }
    },
    data(){
        return{
            user: {
                name: '',
                email: '',
                password: '',

                whatsapp: '',
                phone: '',

                state_id: '',
                district_id: '',
                city_id: '',
            },
            data:{
                states: [],
                districts: [],
                cities: [],
            },
            errors: {}
        }
    },

    watch:{
        user:{
            handler(n){
                if(n.whatsapp){
                    n.whatsapp = Number(n.whatsapp)
                }
            },
            deep:true
        }
    },

    methods: {
        submit() {
            this.$axios.post('auth/update', this.user)
            .then(res => {
                this.$emit('refresh')
                this.$router.push({name: this.redirectName})
                window.scrollTo(0, 0)
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
        async selectState(e){
            this.reset(['cities', 'districts'])

            if(e){
                const state = await this.$axios.$get(`cities/${e}`)
                if(state.type == 'cities'){
                    this.data.cities = state.data
                }else if(state.type == 'districts'){
                    this.data.districts = state.data
                }
            }else{
                this.data.cities = []
            }

        },
        async selectDistrict(e){
            this.reset(['cities'])

            if(e){
                const district = this.data.districts.find(i=>i.id == e)
                this.data.cities = district.cities
            }else{
                this.data.cities = []
            }

        },
        reset(data){
            if(data.includes('districts')){
                this.user.district_id = ''
                this.data.districts = {}
            }
            if(data.includes('cities')){
                this.user.city_id = ''
                this.data.cities = {}
            }
        }
    },
    computed:{
        isEmptyErrors() {
            for(var prop in this.errors) {
                if(Object.prototype.hasOwnProperty.call(this.errors, prop)) {
                return false;
                }
            }

            return JSON.stringify(this.errors) === JSON.stringify({});
        }
    }
}
</script>

<style>
#whatsapp{
    border-top-left-radius: 0% !important;
    border-bottom-left-radius: 0% !important;
}

#phone{
    border-top-left-radius: 0% !important;
    border-bottom-left-radius: 0% !important;
}
</style>