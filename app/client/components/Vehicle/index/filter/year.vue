<template>
    <div>
        <h5 class="text-lg">
            Año
        </h5>
        <div class="text-gray-800 hover:text-gray-600 text-sm">
            <div class="mt-2" v-for="year in years" :key="year.text">
                <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({...query, year_max:year.max, year_min:year.min , page:null})}" class="small text-gray-800 hover:text-gray-600">{{year.text}}</NuxtLink>
            </div>

            <div class="flex mt-3">
                <input v-model="year_min" type="text" id="year_min" class="w-5/12 h-10 border py-2.5 px-2 rounded-lg text-sm flex-grow bg-gray-50 border-gray-400 focus:border-blue-500 focus:ring-blue-500 placeholder-gray-600 text-gray-900" placeholder="mínimo">
                <div class="mx-1 flex items-center">
                    <div class="w-1 border-t border-gray-600 mb-1"></div>
                </div>
                <input v-model="year_max" type="text" id="year_max" class="w-5/12 h-10 border py-2.5 px-4 rounded-lg text-sm flex-grow bg-gray-50 border-gray-400 focus:border-blue-500 focus:ring-blue-500 placeholder-gray-600 text-gray-900" placeholder="máximo">
                <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({...query, year_max: this.year_max, year_min: this.year_min, page:null}) }" class="w-2/12 py-2 text-primary items-center flex justify-center hover:text-blue-500">
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
            year_min: '',
            year_max: '',
            years: [
                {min: null, max: 2000, text: 'Hasta 2000'},
                {min: 2000, max: 2010, text: 'De 2000 a 2010'},
                {min: 2015, max: 2020, text: 'De 2015 a 2020'},
                {min: 2020, max: null, text: 'Desde 2020'},
            ]
        }
    },
}
</script>