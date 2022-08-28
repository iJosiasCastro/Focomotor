<template>
<App>

    <div class="h-5 md:h-20"></div>
    <section class="max-w-4xl mx-auto px-2">
        <div>
            <div class="text-center sm:text-left border-b-2 border-gray-300 flex flex-col items-center justify-between py-3 sm:flex-row">
                <div>
                    <h2 class="font-normal text-xl">{{user.name}}</h2>
                    <p class="text-gray-600 text-sm">{{user.email}}</p>
                </div>
                <div class="bg-gray-200 rounded-lg text-center mt-2">
                    <div class="flex flex-wrap flex-col sm:flex-row items-center justify-around gap-1 sm:gap-4 p-2 px-4">
                        <NuxtLink :to="{name: 'user.dashboard'}" class="text-primary">Mis vehículos</NuxtLink>
                        <hr>
                        <NuxtLink :to="{name: 'user.edit' }">Editar mis datos</NuxtLink>
                        <hr>
                        <NuxtLink :to="{name:'vehicle.create'}">Publicar</NuxtLink>
                    </div>
                </div>
                <div class="text-lg flex mt-2">
                    <button @click="$auth.logout()" class="bg-red-600 duration-500 hover:opacity-75 opacity-100 px-5 py-2 rounded text-white transition-opacity">
                        Salir
                    </button> 
                </div>
            </div>
            <div class="flex flex-col text-gray-600 text-sm sm:block mt-3">
                <span class="mb-2 sm:mr-4 sm:mb-0">Plan: {{user.role.name}}</span>
                <span>Publicaciones restantes: {{user.role.max_vehicles-vehicles.length}}/{{user.role.max_vehicles}}</span>
            </div>
        </div>
        <div class="h-5 md:h-20"></div>
        <h1 class="font-normal text-2xl">Mis Vehículos</h1>
        <div class="gap-2 grid grid-cols-2 mt-3 md:gap-4 md:grid-cols-3">
            <VehicleCard class="col-4" v-for="(v) in vehicles" :key="v.id" :vehicle="v">
                <div class="absolute top-2 right-2 z-40">
                    <button @click="vehicleSelected = v; showDeleteModal=true">
                        <i class="bg-white fa-sm fa-trash fas p-2 pointer rounded-full shadow text-red-600"></i>
                    </button>
                    
                    <NuxtLink :to="{ name: 'vehicle.edit', params:{slug:v.slug} }">
                        <i class="bg-white fa-sm fa-edit fas p-2 pointer rounded-full shadow text-primary"></i>
                    </NuxtLink>
                </div>
            </VehicleCard>
        </div>
        <div v-if="!vehicles.length">
            <div class="text-center">
                <h5 class="my-4">
                    Aun no publicastes ningún vehículo
                </h5>
                <NuxtLink :to="{ name: 'vehicle.create' }" class="bg-primary duration-500 hover:opacity-75 opacity-100 px-5 py-2 rounded-lg text-white transition-opacity">
                    Publicar ahora
                </NuxtLink > 
            </div>
        </div>

    </section>
    <div class="h-5 md:h-20"></div>


    <PartialsModal :show="showDeleteModal" @close="showDeleteModal = false">
        <div class="p-6 text-center">
            <svg class="mx-auto mb-4 w-14 h-14 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h3 class="mb-5 text-lg font-normal text-gray-800">¿Realmente querés eliminar tu publicación?</h3>
            <button @click="destroy(vehicleSelected); showDeleteModal = false" data-modal-toggle="delete_modal" type="button" class="mb-2 text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300  font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                Si, estoy seguro
            </button>
            <button @click="showDeleteModal = false" class="mb-2 text-gray-600 bg-white hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-400 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Cancelar</button>
        </div>
    </PartialsModal>


</App>
</template>

<script>
export default {
    middleware: 'auth',
    head(){
        return {
            title: 'Cuenta - Focomotor'
        }
    },
    data(){
        return {
            vehicleSelected: {},
            showDeleteModal: false
        }
    },
    async asyncData({ $axios }){
        const user  = await $axios.$get('auth/user')
        const vehicles  = await $axios.$get('auth/user/vehicles')
        return {user, vehicles}
    },
    methods:{
        destroy(v){
            this.$axios.$delete(`vehicle/${v.slug}`)
                .then(res => {
                    this.vehicles = res
                })
                .catch(err => console.error(err))
        }
    }
}
</script>