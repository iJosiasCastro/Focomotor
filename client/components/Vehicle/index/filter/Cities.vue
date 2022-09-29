<template>
    <div>
        <h5 class="text-lg">
            Ciudad
        </h5>
        <div class="text-sm">
            <div v-for="city in citiesMap" :key="city.slug" class="mt-2">
                <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({...query, city:city.slug, page: null}) }" class="small text-gray-800 hover:text-gray-600">{{city.name}}</NuxtLink>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['query', 'cities'],
    mounted(){
        console.log("Init:")
        console.log(this.cities)
        this.cities.data.forEach((e)=>{
            e.cities.forEach((b)=>{
                this.citiesMap.push(b)
            })
        })
        console.log("Result:")
        console.log(this.citiesMap)
    },
    data(){
        return{
            citiesMap: []
        }
    }
}
</script>