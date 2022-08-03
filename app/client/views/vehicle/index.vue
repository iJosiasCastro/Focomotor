<template>
<App>
    <VehicleIndexFilters :categories="categories" :cities="cities" :fuels="fuels" :page="page" :query="query" :vehicles="vehicles">

        <VehicleCard v-for="(v,i) in vehicles" :key="i" :vehicle="v"/>

    </VehicleIndexFilters>
      
    <!-- <div class="hidden">
      <NuxtLink v-if="page.prev" :to="{name: 'vehicle.index', query: {page: page.current-1} }">Anterior</NuxtLink>
      <NuxtLink v-if="page.next" :to="{name: 'vehicle.index', query: {page: page.current+1} }">Siguiente</NuxtLink>
    </div> -->

</App>
</template>

<script>
export default {
  head(){
      return {
          title: 'Vehículos - Focomotor'
      }
  },
  async asyncData({ $axios, query }){
    const {prev_page_url, next_page_url, current_page, links, data} = await $axios.$get('vehicles?'+ new URLSearchParams(query).toString())
    const categories = await $axios.$get('categories')
    const cities = await $axios.$get('cities_filter')
    const fuels = await $axios.$get('fuels')
    return {
      query,
      categories,
      cities,
      fuels,
      vehicles: data,
      
      page: {
        links,
        prev: prev_page_url,
        next: next_page_url,
        current: current_page
      }
    }
  },
  methods:{
    loadVehicles(){
      // location.reload();
      // window.scrollTo(0,0)
      // this.$nuxt.refresh()
      
    },
    infiniteScroll($state){
      this.page.current++
      const query = {...this.$route.query, page: this.page.current} 
      this.$axios.$get('vehicles?'+ new URLSearchParams(query).toString())
        .then(res => {
          if(res.data.length){
            res.data.forEach(v => this.vehicles.push(v))
            $state.loaded()
          }else{
            $state.complete()
          }
        })
    }
  },
  async watchQuery(v){
    if(this){
      const {prev_page_url, next_page_url, current_page, links, data} = await this.$axios.$get('vehicles?'+ new URLSearchParams(v).toString())
      this.vehicles = data,
      
      this.page = {
        links,
        prev: prev_page_url,
        next: next_page_url,
        current: current_page
      }
      window.scrollTo(0,0)
    }

    
  }
}
</script>