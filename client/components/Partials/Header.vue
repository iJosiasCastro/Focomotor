<template>
  <nav class="bg-white py-2 shadow md:py-4">
      <div class="flex justify-between max-w-screen-xl mx-auto px-4">
          <div class="flex items-center" :class="{'hidden' : searchState}">
              <NuxtLink :to="{name:'home'}"><img src="/img/logo/focomotor-primario.png" width="160px"></NuxtLink>
          </div>

          <div class="lg:block w-full lg:w-4/12" :class="{'hidden' : !searchState}"> 
            <div class="flex">
              <div class="relative w-full">
                <input ref="search" type="text" v-model="searchText" @keydown.enter="$refs.searchLink.$el.click(); $refs.search.blur()" placeholder="Buscar vehículos..." class="bg-gray-50 block border border-gray-400 focus:border-blue-500 focus:ring-blue-500 py-2 px-4 placeholder-gray-600 rounded-lg text-gray-900 w-full">
                <NuxtLink ref="searchLink" :to="{name: 'vehicle.index', query: {search: this.searchText} }" type="submit" class="flex items-center absolute top-0 right-0 h-full px-3 text-white bg-primary rounded-r-lg border border-primary hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                  <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                  </svg>
                </NuxtLink>
              </div>
            </div>
          </div>
          
          <!-- Desktop menu -->
          <div class="flex-row hidden text-lg lg:flex" id="navbar-collapse">
              <NuxtLink :to="{name:'vehicle.index'}" class="duration-100 hover:text-gray-700 p-2 text-gray-800 transition-colors md:mx-2 lg:px-4">
                Listado
              </NuxtLink>
              <NuxtLink :to="{name:'vehicle.create'}" class="duration-100 hover:text-gray-700 p-2 text-gray-800 transition-colors md:mx-2 lg:px-4">
                Publicá
              </NuxtLink>
              <NuxtLink v-if="$auth.loggedIn" :to="{name:'user.dashboard'}" class="flex">
                <div class="hover:opacity-75 opacity-100 my-auto text-3xl text-primary">
                  <i class="fa-user-circle fas h-8 mr-1"></i>
                </div>
                <span class="my-auto hover:text-gray-800 rounded-lg text-gray-800">Mi cuenta</span>
              </NuxtLink>
              <NuxtLink v-else :to="{name:'user.login'}" class="bg-primary duration-500 hover:opacity-75 my-1 opacity-100 px-3 py-1 rounded-lg text-white transition-opacity md:mx-2 lg:px-4">
                Ingresar
              </NuxtLink>
          </div>

          <!-- Mobile menu -->
          <div class="flex gap-5 items-center" :class="{'hidden' : searchState}">
            <div class="hover:opacity-75 opacity-100 text-2xl text-primary lg:hidden" id="navbar-toggle">
                <button @click="searchMode()" class="fa-search fas"></button>
            </div>
            <div class="hover:opacity-75 opacity-100 text-3xl text-primary lg:hidden" id="navbar-toggle">
                <NuxtLink :to="{name:'user.dashboard'}" class="fa-user-circle fas h-8"></NuxtLink>
            </div>
          </div>
      </div>
  </nav>
</template>

<script>
export default {
  mounted(){
    this.$refs.search.addEventListener('focusout', ()=>{
      setTimeout(()=>{
        this.searchState = false
      },100)
    })
  },
  methods:{
    logout(){
      this.$auth.logout()
    },
    async searchMode(){
      await new Promise((r)=>{
        this.searchState = true;
        r()
      })

      this.$refs.search.focus()

    },
  },
  data(){
    return {
      searchText: '',
      searchState: false
    }
  },

}
</script>