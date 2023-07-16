<template>
<App>
    <PartialsTitle background_num="1" title="Editar" />
    <div class="max-w-xl mx-auto px-2">
        <div class="h-10 lg:h-16"></div>
        
        <div v-if="$auth.loggedIn">
            <VehicleForm :editable="v" :receivedData="data" />
        </div>

        <div v-if="$store.state.auth.user.id == 23">
            <button @click="destroyAdmin" class="my-5 w-full bg-red-600 duration-500 hover:opacity-75 opacity-100 px-5 py-2 rounded-lg text-white transition-opacity">Eliminar vehículo</button>
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

        data.brands = await $axios.$get(`brands/${v.category_id}`)
        data.models = v.brand_id ? await $axios.$get(`models/${v.category_id}/${v.brand_id}`) : {}

        return {v,data}
    },
    methods:{
        destroyAdmin(){
            if(confirm('¿Realmente querés eliminar la publicación?')){
                this.$axios.$delete(`vehicle/${this.v.slug}`)
                    .then(res => {
                        this.vehicles = res
                    })
                    .catch(err => console.error(err))
                alert('La publicación fué eliminada')
            }
        }
    }
}
</script>