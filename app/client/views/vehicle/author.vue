<template>
    <App>
        <section class="max-w-3xl mx-auto px-2 lg:max-w-5xl">
            <div class="h-10 md:h-24"> 
            </div>

            <div class="border-b-2 border-gray-300">
                <div class="text-center">
                    <div class="flex justify-center">
                        <div class="my-auto text-3xl text-primary">
                            <i class="fa-user-circle fas h-8 mr-1"></i>
                        </div>
                        <h1 class="font-normal text-2xl">{{data.user.name}}</h1>
                    </div>
                    <p class="flex flex-col text-gray-600 text-sm sm:block"><span class="mb-2 sm:mr-4 sm:mb-0">{{data.user.role_id == 1 ? 'Particular' : 'Concesionaria'}}</span></p>
                </div>
                <div class="h-4"></div>
            </div>
            <div class="h-5 md:h-16"></div>

            <div class="gap-2 grid grid-cols-2 mt-3 md:gap-4 md:grid-cols-3">
                <VehicleCard
                    v-for="vehicle in data.vehicles"
                    :key="vehicle.id"
                    :vehicle="vehicle"
                />
            </div>
        </section>
    </App>
</template>

<script>
export default {
    head(){
        return {
            title: this.data.user.name + ' - Focomotor'
        }
    },
    async asyncData({$axios, params, error}){
        return await $axios.$get('author/'+params.slug)
        .then(res => {
            return {data: res}
        })
        .catch(()=> error({status: 404}))
    },
}
</script>
