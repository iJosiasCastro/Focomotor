<template>
    <section class="bg-auto bg-center flex flex-wrap items-center justify-center pt-10 pb-12 md:pt-20 md:pb-24 md:bg-cover" style="background-image: url('img/headers/header-home.jpg');">
        <div class="max-w-3xl px-2 w-full flex flex-wrap justify-center">
            <div class="font-semibold text-3xl text-shadow text-white text-center">
                <h1 class="font-sans">¿Qué estás buscando?</h1>
            </div>
            <div class="bg-gray-100 bg-opacity-75 max-w-2xl mt-3 py-4 rounded-lg text-xl w-full">
                <div class="grid grid-cols-1 justify-center px-1 w-full md:grid-cols-3 md:px-4">
                    <select  @change="selectCategory()" v-model="category" class="border-gray-200 cursor-pointer focus:outline-none m-2 p-2 rounded-lg text-gray-700">
                        <option value="">Categorias</option>
                        <option v-for="e in categories" :key="e.id" :value="e.slug">{{e.name}}</option>
                    </select>
                    <select v-model="brand" class="border-gray-200 cursor-pointer focus:outline-none m-2 p-2 rounded-lg text-gray-700">
                        <option value="">Marcas</option>
                        <option v-for="e in brands" :key="e.id" :value="e.slug">{{e.name}}</option>
                    </select>
                    <select v-model="city" class="border-gray-200 cursor-pointer focus:outline-none m-2 p-2 rounded-lg text-gray-700">
                        <option value="">Ubicación</option>
                        <option v-for="e in cities" :key="e.id" :value="e.slug">{{e.name}}</option>
                    </select>
                </div>
                <div class="h-2"></div>
                <div class="flex justify-center text-lg">
                    <NuxtLink :to="{name: 'vehicle.index', query: $store.getters.notEmpty({category: this.category, brand: this.brand, city: this.city}) }" 
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
    props:['categories', 'cities', 'brands'],
    data(){
        return {
            category: '',
            brand: '',
            city: ''
        }
    },
    methods:{
        async selectCategory(){
            this.brand = ''
            const e = this.categories.findIndex(e => e.slug == this.category)+1

            if(e){
                var res = await this.$axios.$get(`categories/${e}`)
                this.$emit('selectCategory', res)
            }

        },
    }
}
</script>