<template>
<App>
    <VehicleIndexFilters :categories="categories" :states="states" :brands="brands" :models="models" :cities="cities" :fuels="fuels" :page="page" :query="query" :vehicles="vehicles">

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
          title: 'Vehículos - Focomotor',
          scripts: [
            { hid: 'adsense', src: 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js', defer: true, 'data-ad-client': 'ca-pub-5902667990414861' },
          ]
      }
  },
  mounted(){
    this.$nextTick(() => {
      try {
        // this is required for each ad slot (calling this once will only load 1 ad)
        (window.adsbygoogle = window.adsbygoogle || []).push({})
      } catch (error) {
        console.error(error)
      }
    })
  },
  async asyncData({ $axios, query }){
    const {prev_page_url, next_page_url, current_page, links, data} = await $axios.$get('vehicles?'+ new URLSearchParams(query).toString())
    const categories = await $axios.$get('categories')
    const states = await $axios.$get('filter/states')
    const fuels = await $axios.$get('fuels')
    var brands = []
    var cities = []
    var models = []

    if(query.category){
      brands = await $axios.$get(`filter/brands/${query.category}`)
    }

    
    if(query.brand){
      models = await $axios.$get(`filter/models/${query.category}/${query.brand}`)
    }

    if(query.state){
      cities = await $axios.$get(`filter/cities/${query.state}`)
      var citiesMap = []
      cities.data.forEach((e)=>{
        citiesMap.push(e)
      })

      cities = citiesMap
    }

    return {
      query,
      categories,
      states,
      cities,
      brands,
      models,
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
    // if(this){
    //   const {prev_page_url, next_page_url, current_page, links, data} = await this.$axios.$get('vehicles?'+ new URLSearchParams(v).toString())
    //   this.vehicles = data,
      
    //   this.page = {
    //     links,
    //     prev: prev_page_url,
    //     next: next_page_url,
    //     current: current_page
    //   }
    //   window.scrollTo(0,0)
    // }
  }
}
</script>