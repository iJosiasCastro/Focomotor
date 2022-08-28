<template>
<App>
    <h1 class="hidden">Focomotor</h1>

    <PartialsHomeSearchMenu :receivedData="data" />

    <div class="h-10 lg:h-16"></div>

    <section class="max-w-3xl mx-auto px-2">
      <h2 class="font-normal text-2xl">Ultimas publicaciones</h2>
      <div class="gap-2 grid grid-cols-2 mt-3 md:gap-4 md:grid-cols-3">
        <VehicleCard v-for="v in vehicles" :key="v.id" :vehicle="v"/>
      </div>
      <div class="flex justify-center mt-5">
        <NuxtLink :to="{ name: 'vehicle.index' }" class="bg-primary duration-500 hover:opacity-75 opacity-100 px-5 py-2 rounded-lg text-white transition-opacity">
            Ver todos los vehículos
        </NuxtLink>
      </div>
    </section>

    <div class="h-10 lg:h-16"></div>
    
    <PartialsHomeConcessionairePromotion />

    <section class="max-w-3xl px-2 mx-auto">
      <div class="h-10 lg:h-16"></div>

      <PartialsAds :ads="[
        'Singla Electricidad',
        'Electrauto repuestos Olavarria',
        'Tavernini Servicio y Reparacion de cajas automaticas Olavarria',
        'Claudio Trezza Seguros Olavarria'
      ]" />

      <div class="h-10 lg:h-16"></div>

      <PartialsHomePopularBrands />

      <div class="h-10 lg:h-16"></div>

      <div class="max-w-2xl mx-auto grid grid-cols-2 md:grid-cols-2 gap-2 md:gap-16">
        <PartialsAds class="w-full"
          :ads="[
            'Magford Repuestos Ford Olavarria',
            'Total Autopartes Olavarria',
            'Bloquera Falasco Olavarria',
            'Parini fotocopiadoras Olavarria'
          ]" />
        
        <PartialsAds class="w-full"
          :ads="[
            'El Taller De Chapa Olavarria',
            'Givier Libreria Olavarria',
            'Mosaicos David Olavarria',
            'Don Raul Verduleria Olavarria'
          ]" />
      </div>


    </section>


    
    



</App>
</template>

<script>
export default {
  head(){
      return {
          title: 'Focomotor - Tu lugar para comprar y vender vehículos'
      }
  },
  async asyncData({ $axios }){
    const data = {
        categories: [],
        brands: [],
        models: [],
        // states: [],
        // districts: [],
        // cities: [],
    }

    var vehicles

    await Promise.all([
        $axios.$get('categories').then(r => data.categories=r),
        $axios.$get('filter/brands/1').then(r => data.brands=r),
        // $axios.$get('states').then(r => data.states=r),
        $axios.$get('vehicles/home').then(r => vehicles=r),
    ])

    return {vehicles, data}
  },
}
</script>
