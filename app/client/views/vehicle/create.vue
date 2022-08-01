<template>
<App>
    <PartialsTitle background_num="1" title="Publicar" />
    <div class="max-w-xl mx-auto px-2">
        <div class="h-10 lg:h-16"></div>

        <div v-if="data.user">
            <div v-if="(data.user.vehicles_count+1 <= data.user.role.max_vehicles)">
                <VehicleForm :receivedData="data" />
            </div>
            <div v-else>
                <VehicleBuyPlans/>
            </div>
        </div>
        <div v-else>
            <PartialsSubtitle subtitle="¡Hola! Para publicar primero debes ingresar" />
            <div class="h-5"></div>
            <UserLogin redirectName="user.dashboard" />
        </div>
    </div>
</App>
</template>

<script>
export default {
    head(){
        return {
            title: 'Publicá tus vehículos - Focomotor'
        }
    },
    async asyncData({$axios, $auth}){
        const data = {
            brands: {},
            models: {}
        }

        await Promise.all([
            $axios.$get('categories').then(r => data.categories=r),
            $axios.$get('fuels').then(r => data.fuels=r),
            $axios.$get('states').then(r => data.states=r),
            $axios.$get('years').then(r => data.years=r),
        ])

        if($auth.loggedIn){
            data.user = await $axios.$get('auth/user')
        }

        return {data}
    }
}
</script>