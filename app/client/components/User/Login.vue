<template>
<div class="text-lg p-3 py-8 md:py-16 bg-gray-100 border border-gray-400 border-solid rounded-lg shadow-lg text-center">
  <div class="max-w-md mx-auto">
    <div v-if="!showEmailLogin">
      <!-- Google -->
      <div class="flex justify-center">
          <a :href="$axios.defaults.baseURL+'google-login'" class="bg-primary duration-500 hover:opacity-75 opacity-100 rounded-lg text-white transition-opacity flex">
            <div class="bg-gray-100 border-2 border-primary flex rounded-lg text-blue-600">
                <img class="h-8 my-auto mx-2" src="/img/partials/google-logo.png"/>
            </div>
            <div class="px-4 py-3">
                Continuar con <span class="font-bold">Google</span>
            </div>
          </a>
      </div>

      <div class="relative flex py-8 items-center">
        <div class="flex-grow border-t border-gray-500"></div>
        <span class="flex-shrink mx-4 text-gray-600">O</span>
        <div class="flex-grow border-t border-gray-500"></div>
      </div>

      <!-- Email -->
      <div class="flex justify-center">
      <button @click="showEmailLogin=true" class="flex bg-gray-800 duration-500 hover:opacity-75 opacity-100 px-3 py-2 rounded-lg text-lg text-white transition-opacity">
          <i class="fa-envelope far mr-2 h-5 my-auto"></i>
          Ingresar con Email 
      </button>
  </div>
    </div>

  <div v-else>
    <UserEmailLogin :redirectName="redirectName" @close="showEmailLogin=false" />
  </div>

  </div>


</div>
</template>

<script>
export default {
  props: ['redirectName'],
  data(){
    return{
      showEmailLogin: false,
      error: null
    }
  },
}
</script>