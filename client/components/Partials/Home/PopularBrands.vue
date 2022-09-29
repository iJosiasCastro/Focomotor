<template>
    <section class="max-w-3xl mx-auto px-2">

        <h1 class="font-normal text-2xl">Marcas más buscadas</h1>
        <div class="gap-2 grid grid-cols-2 mt-3 md:gap-4 md:grid-cols-3">
            <NuxtLink v-for="brand in brands" :key="brand" class="border duration-200 hover:-translate-y-1 hover:shadow-xl max-w-sm overflow-hidden rounded-lg shadow transform transition-all"
                :to="{name: 'vehicle.index', query: $store.getters.notEmpty({brand: brand.toLowerCase()}) }">
                <div class="bg-cover bg-center h-0 block w-full"
                    :style="{'background-image' : `url(img/marcas/${brand}.jpg)`}" style="padding-top: 70.37%">
                </div>
                <!-- <img class="w-full h-40 object-cover" :src="`img/marcas/${brand}.jpg`"> -->
                <div class="bg-gray-100 px-3 py-3 sm:py-5 text-center text-gray-900">
                    <div class="flex justify-center">
                        <img :src="`img/marcas/${brand}.png`" class="-mt-10 bg-gray-100 h-14 w-14 sm:h-20 sm:w-20 object-cover rounded-full shadow "/>
                    </div>         
                    <div class="pt-1 sm:pt-2">
                        <span class="text-xl">{{brand}}</span>
                    </div>
                </div>
            </NuxtLink>

        </div>
    </section>
</template>

<script>
export default {
    data(){
        return{
            brands : ['Toyota', 'Volkswagen', 'Fiat', 'Renault', 'Peugeot', 'Ford']
        }
    }
}
</script>