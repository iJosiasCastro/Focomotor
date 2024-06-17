<template>
  <App>
    <PartialsTitle title="Planes" background_num="7" />
    <div class="h-5"></div>
    <section class="max-w-4xl mx-auto px-2">
        <div class="h-5 md:h-8"></div>
        <div class="max-w-3xl mx-auto">
            <p class="font-normal text-center">
                Nuestros planes se adaptan a tus unidades para que puedas publicar en
                Focomotor con un precio amigable. ¡Impulsá tus ventas de vehículos
                ahora!
            </p>
        </div>
        <div class="h-8 md:h-12"></div>
        <div class="flex flex-wrap mt-3 gap-2 justify-center">
          <div v-for="plan in plans" :key="plan.name" class="w-full md:w-1/3 -mx-1 p-2">
            <div class="mx-auto text-gray-700 border duration-200 hover:-translate-y-1 hover:shadow-xl overflow-hidden rounded-lg shadow transform transition-all">
                <div class="bg-primary font-bold py-3 text-center text-white text-xl">
                    <h3>{{plan.name}}</h3>
                </div>
                <div class="h-8"></div>
                <div class="text-center leading-3 font-extrabold">
                    <h4>
                        <span class="text-xl">$</span><span class="text-5xl">{{plan.price}}</span><br />
                        <span class="font-normal">por mes</span>
                    </h4>
                </div>
                <div class="h-8"></div>

                <div class="flex text-sm justify-center text-black">
                    <i class="text-green-600 fa-check fas mr-2 my-auto"></i>
                    <p>Hasta {{plan.vehicles}} vehículos a la vez</p>
                </div>

                <div class="h-8"></div>
                <div class="text-lg text-center">
                    <NuxtLink :to="{ name:'plan.show', params:{slug: plan.name} }" class="bg-primary duration-500 hover:opacity-75 opacity-100 px-5 py-2 rounded-lg text-white transition-opacity">
                        Contratar
                    </NuxtLink> 
                </div>

                <div class="h-8"></div>

            </div>
          </div>
      </div>
    </section>
  </App>
</template>

<script>
export default {
  head() {
    return {
      title: "Planes de publicación - Focomotor",
    };
  },
  data(){
    return {
        plans: [
            {name: 'x5 Publicaciones', class: 'md:col-span-4', price: '5.000', vehicles: 5},
            {name: 'x10 Publicaciones', class: 'md:col-span-4', price: '9.000', vehicles: 10},
            {name: 'x20 Publicaciones', class: 'md:col-span-4', price: '15.000', vehicles: 20},
            {name: 'x50 Publicaciones', class: 'md:col-span-4', price: '25.000', vehicles: 50},
            {name: 'x100 Publicaciones', class: 'md:col-span-4', price: '40.000', vehicles: 100},
        ]
    }
  }
};
</script>