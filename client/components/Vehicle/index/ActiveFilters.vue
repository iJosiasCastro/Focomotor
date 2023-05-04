<template>
    <div>
        <button v-for="(v,k) in $store.getters.notEmpty({...query, orderBy:null,page:null})" :key="k" class="mr-1">
            <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({ ...query, [k]:null , page:null}) }" class="bg-primary hover:opacity-75 text-white text-xs font-semibold items-center inline-flex h-5 px-2.5 py-0.5 rounded">
                {{ show(v,k) }}
                <div class="text-white ml-1 my-auto h-4 rounded-lg text-sm">
                    <svg class="h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </div>
            </NuxtLink>
        </button>
        <div class="h-3" v-if="Object.keys($store.getters.notEmpty({...query, orderBy:null, page:null})).length"></div>
    </div>
</template>

<script>
export default {
    props: ['query'],
    data(){
        return{
            dictionary:{
                search: 'Búsqueda: ',
                price_max: 'Hasta $',
                price_min: 'Desde $',
                year_min: 'Desde ',
                year_max: 'Hasta ',
                mileage_min: 'Desde ',
                mileage_max: 'Hasta ',
            }
        }
    },
    methods:{
        show(v,k){
            var res = ''
            function capitalize(v){return v.charAt(0).toUpperCase() + v.slice(1)}
            if(this.dictionary[k]){
                res = this.dictionary[k]
            }
            if(Number(v) && k.includes('price')){
                return res + this.$store.getters.numFormater(Number(v))
            }else if(Number(v) && k.includes('mileage')){
                return res + this.$store.getters.numFormater(Number(v)) + 'km'
            }else if(Number(v) && k.includes('year')){
                return res + v
            }else{
                return res + capitalize(v).replace(/-/g, ' ')
            }
        }
    }
}
</script>