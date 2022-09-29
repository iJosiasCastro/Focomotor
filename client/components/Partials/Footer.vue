<template>
  <footer>
    <div class="h-24 md:h-48"></div>
    <div class="bg-gray-900 hidden py-2 shadow md:py-4 lg:block">
        <div class="flex justify-between max-w-screen-xl mx-auto px-4">
            <div class="flex items-center">
              <NuxtLink :to="{name:'home'}">
                <img src="/img/logo/focomotor-blanco.png" width="160px">
              </NuxtLink>
            </div>
            <div class="flex-row hidden text-base text-white lg:flex" id="navbar-collapse">
                <NuxtLink :to="{name:'info.policy'}" class="p-2 md:mx-2 lg:px-4">
                  Política de Privacidad
                </NuxtLink>
                <NuxtLink :to="{name:'info.terms'}" class="p-2 md:mx-2 lg:px-4">
                  Terminos y Condiciones
                  </NuxtLink>
                <NuxtLink :to="{name:'info.contact'}" class="p-2 md:mx-2 lg:px-4">
                  Contacto
                </NuxtLink>
                <a href="https://play.google.com/store/apps/details?id=ar.com.foco.focomotor">
                  <img class="h-10" src="/img/partials/appstore.png">
                </a>
            </div>
        </div>
    </div>
    <div class="bg-white border bottom-0 fixed flex justify-around pb-1 pt-2 shadow-inner text-sm w-full z-20 lg:hidden">
        <NuxtLink :to="{ name:'home' }" class="flex flex-col justify-center max-w-full min-w-0 text-center text-gray-800 w-full">
          <i class="fa-home fas text-2xl h-6 mx-auto"></i>
          <span class="mx-auto">Inicio</span>
        </NuxtLink>
        <NuxtLink :to="{ name:'vehicle.index' }" class="flex flex-col justify-center max-w-full min-w-0 text-center text-gray-800 w-full">
          <i class="fa-car-alt fas text-2xl text-2xl h-6 mx-auto"></i>
          <span class="mx-auto">Listado</span>
        </NuxtLink>
        <NuxtLink :to="{ name:'vehicle.create' }" class="flex flex-col justify-center max-w-full min-w-0 text-center text-gray-800 w-full">
          <i class="h-6 fa-wpforms fab text-2xl mx-auto"></i>
          <span class="mx-auto">Publicar</span>
        </NuxtLink>
        <button @click="showInfoModal=true" class="flex flex-col justify-center max-w-full min-w-0 text-center text-gray-800 w-full">
          <i class="fa-info-circle fas h-6 mx-auto text-2xl"></i>
          <span class="mx-auto">Info.</span>
        </button>
        <PartialsInfoModal :show="showInfoModal" @close="showInfoModal=false" />
    </div>


  </footer>
</template>

<script>
export default {
  data(){
    return {
      showInfoModal: false
    }
  }
}
</script>