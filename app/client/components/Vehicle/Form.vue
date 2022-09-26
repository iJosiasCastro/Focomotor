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

    <div>
        <div v-if="!userComplete">
            <div class="text-center mt-5">
                <h3 class="text-2xl">Para publicar primero tenés que completá tus datos de usuario</h3>
                <div class="h-10"></div>
                <UserForm redirectName="vehicle.create" @refresh="userComplete = true" :editable="data.user" />
            </div>
        </div>

        <form v-else @submit.prevent="submit()">
            <div>  
                <PartialsFormInput v-model="vehicle.title" type="text" name="title" label="Título" placeholder="Ingresá el título"
                    :required="true" :errors="errors" @clearError="errors.title = null" tag="input" />


                <PartialsFormInput name="category_id" label="Categoría" :errors="errors" @clearError="errors.category_id = null" >
                    <select required @change="selectCategory()" v-model="vehicle.category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">Selecciona una categoría</option>
                        <option v-for="category in data.categories" :key="category.id" :value="category.id">{{category.name}}</option>
                    </select>
                </PartialsFormInput>
                
                <PartialsFormInput  name="brand_id" label="Marca" :errors="errors" @clearError="errors.brand_id = null" >
                    <select :disabled="!data.brands.length" @change="selectBrand()" v-model="vehicle.brand_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <!-- <option value="">Selecciona una marca</option> -->
                        <template v-if="data.brands.length">
                            <option value="">Otro</option>
                            <option v-for="brand in data.brands" :key="brand.id" :value="brand.id">{{brand.name}}</option>
                        </template>
                        <template v-else>
                            <option value="">Primero seleccioná una categoría</option>
                        </template>
                    </select>
                </PartialsFormInput>

                <PartialsFormInput v-if="vehicle.category_id <= 3" name="model_id" label="Modelo" :errors="errors" @clearError="errors.model_id = null" >
                    <select :disabled="!data.models.length" @change="e=>vehicle.model_id=e.target.value" :value="vehicle.model_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <!-- <option value="">Selecciona un modelo</option> -->
                        <template v-if="data.models.length">
                            <option value="">Otro</option>
                            <option v-for="model in data.models" :key="model.id" :value="model.id">{{model.name}}</option>
                        </template>
                        <template v-else>
                            <option value="">Primero seleccioná una marca</option>
                        </template>
                    </select>
                </PartialsFormInput>

                <PartialsFormInput name="year" label="Año" :errors="errors" @clearError="errors.year = null" >
                    <select required @change="e=>vehicle.year=e.target.value" :value="vehicle.year" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">Seleccioná un año</option>
                        <option v-for="year in data.years" :key="year" :value="year">{{year}}</option>
                    </select>
                </PartialsFormInput>

                <PartialsFormInput v-model="vehicle.mileage" type="number" name="mileage" label="Kilometraje" placeholder="Ingresá el kilometraje"
                    :required="true" :errors="errors" @clearError="errors.mileage = null" tag="input" />
                    

                <PartialsFormInput name="fuel" label="Combustible" :errors="errors" @clearError="errors.mileage = null" >
                    <select v-model="vehicle.fuel_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-lg rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">Otro</option>
                        <option v-for="fuel in data.fuels" :key="fuel.id" :value="fuel.id">{{fuel.name}}</option>
                    </select>
                </PartialsFormInput>

                <PartialsFormInput v-model="vehicle.price" type="number" name="price" label="Precio" placeholder="Ingresá el precio"
                    :required="true" :errors="errors" @clearError="errors.price = null" tag="input" />

                
                <PartialsFormInput name="images" label="Imagenes" :errors="errors" @clearError="errors.images = null">
                    <PartialsImageUploader :editable="vehicle.images" @input="e=>vehicle.images=e" />
                </PartialsFormInput>

                <PartialsFormInput v-model="vehicle.description" type="textarea" name="description" label="Descripción" placeholder="Describí el vehículo"
                        :required="false" :errors="errors" @clearError="errors.description = null" tag="textarea" />

                
                <button type="submit" class="w-full text-lg bg-primary duration-500 hover:opacity-75 opacity-100 px-3 py-2 rounded-lg text-white transition-opacity">
                    {{ editable ? 'Editar' : 'Publicar'}}
                </button>

            </div>
        </form>
    </div>

</div>
</template>

<script>
export default {
    props:['editable', 'receivedData'],
    async fetch(){
        this.data = this.receivedData

        if(this.data.user.state && this.data.user.city){
            this.userComplete = true;
        }

        // Replace null values for '' and save in this.vehicle 
        if(this.editable){
            for (const key in this.vehicle) {
                if(this.editable[key] == null){
                    this.vehicle[key] = ''
                }else{
                    this.vehicle[key] = this.editable[key] 
                }
            }
        }
        
    },
    data(){
        return {
            vehicle:{
                title: '',
                price: null,
                year: null,
                mileage: null,
                description: '',

                fuel_id: '',

                state_id: '',
                city_id: '',

                category_id: '',
                brand_id: '',
                model_id: '',

                images: [],
                description: '',

            },
            data:{
                fuels: [],
                years: [],
                
                states: [],
                cities: [],
    
                categories: [],
                brands: [],
                models: [],
            },
            userComplete:false,
            formData: {},
            errors: {}


        }
    },
    methods:{
        
        async selectState(){
            const e = this.vehicle.state_id
            
            if(e){
                this.data.cities = await this.$axios.$get(`cities/${e}`)
            }else{
                this.data.cities = []
            }

            this.vehicle.city_id = ''
        },
        async selectCategory(){
            const e = this.vehicle.category_id

            if(e){
                this.data.brands = await this.$axios.$get(`brands/${e}`)
            }else{
                this.data.brands = []
            }

            this.vehicle.brand_id = ''
            this.vehicle.model_id = ''
        },
        async selectBrand(){
            const e = this.vehicle.brand_id

            if(e){
                this.data.models = await this.$axios.$get(`models/${this.vehicle.category_id}/${e}`)
            }else{
                this.data.models = []
            }
            
            this.vehicle.model_id = ''
        },
        async submit(){
            const url = this.editable ? `vehicle/${this.editable.slug}` : 'vehicle'
            const method = this.editable ? '$put' : '$post'
            const vehicle = Object.fromEntries(Object.entries(this.vehicle).filter(([k, v]) => v !== ''))
            this.$axios[method](url, vehicle)
                .then(res => {
                    // console.log(vehicle)
                    this.$router.push({name:'user.dashboard'})
                })
                .catch(err => {
                    this.errors = {}
                    if(err.response.data.errors){
                        console.log(err.response.data)
                        window.scrollTo(0, 0)
                        this.errors = err.response.data.errors

                    }else{
                        console.log(err.response)
                        console.error(err)
                    }
                })

        },

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