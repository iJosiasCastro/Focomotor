<template>
    <section class="bg-auto bg-center flex flex-wrap items-center justify-center pt-10 pb-12 md:pt-20 md:pb-24 md:bg-cover" style="background-image: url('img/headers/header-home.jpg');">
        <div class="max-w-3xl px-2 w-full flex flex-wrap justify-center">
            <div class="font-semibold text-3xl text-shadow text-white text-center">
                <h1 class="font-sans">¿Qué estás buscando?</h1>
            </div>
            <div class="bg-gray-100 bg-opacity-75 max-w-3xl mt-3 py-4 rounded-lg text-lg w-full">
                <div class="grid grid-cols-1 justify-center px-1 w-full md:grid-cols-3 md:px-4">
                    <select  @change="selectCategory()" v-model="category_id" class="border-gray-200 cursor-pointer focus:outline-none m-2 p-2 rounded-lg text-gray-700">
                        <option v-for="e in data.categories" :key="e.id" :value="e.id">{{e.name}}</option>
                    </select>
                    <select @change="selectBrand()" v-model="brand_id" class="border-gray-200 cursor-pointer focus:outline-none m-2 p-2 rounded-lg text-gray-700">
                        <option value="">Marca</option>
                        <option v-for="e in data.brands" :key="e.id" :value="e.id">{{e.name}}</option>
                    </select>
                    <select v-model="model_id" :disabled="!data.models.length || category_id > 3" class="border-gray-200 cursor-pointer focus:outline-none m-2 p-2 rounded-lg text-gray-700">
                        <option value="">Modelo</option>
                        <option v-for="e in data.models" :key="e.id" :value="e.id">{{e.name}}</option>
                    </select>
                    <!-- <select v-model="city_id" class="border-gray-200 cursor-pointer focus:outline-none m-2 p-2 rounded-lg text-gray-700">
                        <option value="">Ubicación</option>
                        <option v-for="e in data.states" :key="e.id" :value="e.id">{{e.name}}</option>
                    </select> -->
                </div>
                <div class="h-2"></div>
                <div class="flex justify-center text-lg">
                    <NuxtLink :to="{name: 'vehicle.index', query: $store.getters.notEmpty(filterObj) }" 
                        class="bg-primary duration-500 hover:opacity-75 opacity-100 px-5 py-2 rounded-lg text-white transition-opacity">
                        Buscar
                    </NuxtLink> 
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    props:['categories', 'cities', 'receivedData'],
    async fetch(){
        this.data = this.receivedData
    },
    data(){
        return {
            category_id: 1,
            brand_id: '',
            model_id: '',
            data:{
                states: [],
                cities: [],
    
                categories: [],
                brands: [],
                models: [],
            },
        }
    },
    methods:{
         async selectCategory(){
            const e = this.category_id

            if(e){
                this.data.brands = await this.$axios.$get(`filter/brands/${e}`)
            }else{
                this.data.brands = []
            }

            this.brand_id = ''
            this.model_id = ''
            this.data.models = []
        },
        async selectBrand(){
            const e = this.brand_id

            if(e){
                this.data.models = await this.$axios.$get(`filter/models/${this.category_id}/${e}`)
            }else{
                this.data.models = []
            }
            
            this.model_id = ''
        },
    },
    computed:{
        filterObj(){
            const category = this.data.categories.find(e => e.id == this.category_id)
            const brand = this.data.brands.find(e => e.id == this.brand_id)
            const model = this.data.models.find(e => e.id == this.model_id)
            var data = {}
            if(brand && brand.slug){
                data = {...data, brand: brand.slug}
            }

            if(category && category.slug){
                data = {...data, category: category.slug}
            }

            if(model && model.slug){
                data = {...data, model: model.slug}
            }

            return data
        }
    }
}
</script>