<template>
    <div>
        <h5 class="text-lg">
            Kilometraje
        </h5>
        <div class="text-gray-800 hover:text-gray-600 text-sm">
            <div class="mt-2" v-for="mileage in mileages" :key="mileage.text">
                <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({...query, mileage_max:mileage.max, mileage_min:mileage.min, page:null})}" class="small text-gray-800 hover:text-gray-600">{{mileage.text}}</NuxtLink>
            </div>

            <div class="flex mt-3">
                <input v-model="mileage_min" type="text" id="mileage_min" class="w-5/12 h-10 border py-2.5 px-2 rounded-lg text-sm flex-grow bg-gray-50 border-gray-400 focus:border-blue-500 focus:ring-blue-500 placeholder-gray-600 text-gray-900" placeholder="mínimo">
                <div class="mx-1 flex items-center">
                    <div class="w-1 border-t border-gray-600 mb-1"></div>
                </div>
                <input v-model="mileage_max" type="text" id="mileage_max" class="w-5/12 h-10 border py-2.5 px-4 rounded-lg text-sm flex-grow bg-gray-50 border-gray-400 focus:border-blue-500 focus:ring-blue-500 placeholder-gray-600 text-gray-900" placeholder="máximo">
                <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({...query, mileage_max: this.mileage_max, mileage_min: this.mileage_min, page:null}) }" class="w-2/12 py-2 text-primary items-center flex justify-center hover:text-blue-500">
                    <span class="sr-only">Filtrar</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                </NuxtLink>
            </div>
        </div>
    </div> 
</template>

<script>
export default {
    props:['query'],
    data(){
        return{
            mileage_min: '',
            mileage_max: '',
            mileages: [
                {min: null, max: 50000, text: 'Hasta 50.000km'},
                {min: 50000, max: 100000, text: '50.000km a 100.000km'},
                {min: 100000, max: 250000, text: '100.000km a 250.000km'},
                {min: 250000, max: null, text: 'Más de 250.000 km'},
            ]
        }
    },
}
</script>