<template>
<App>
    <PartialsTitle background_num="1" title="Editar" />
    <div class="max-w-xl mx-auto px-2">
        <div class="h-10 lg:h-16"></div>

        <div v-if="$auth.loggedIn">
            <VehicleForm :editable="v" :receivedData="data" />
        </div>

        <div class="h-5 lg:h-10"></div>
    </div>
</App>
</template>

<script>
export default {
    middleware: 'auth',
    head(){
        return {
            title: 'Editar vehículo - Focomotor'
        }
    },
    async asyncData({params, $axios, $auth}){
        const data = {}
        var v = {}
        // var v = await $axios.$get('vehicle/' + params.slug)
        // data.categories = await $axios.$get('categories')
        // data.fuels = await $axios.$get('fuels')
        // data.states = await $axios.$get('states')
        // data.years = await $axios.$get('years')

        await Promise.all([
            $axios.$get('vehicle/' + params.slug).then(r => v=r),
            $axios.$get('categories').then(r => data.categories=r),
            $axios.$get('fuels').then(r => data.fuels=r),
            $axios.$get('states').then(r => data.states=r),
            $axios.$get('years').then(r => data.years=r),
        ])

        if($auth.loggedIn){
            data.user = await $axios.$get('auth/user')
        }

        data.brands = await $axios.$get(`categories/${v.category_id}`)
        data.models = v.brand_id ? await $axios.$get(`categories/${v.category_id}/${v.brand_id}`) : {}

        return {v,data}
    }
}
</script>