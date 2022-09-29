<template>
    <div>
        <h5 class="text-lg">
            Ubicacion
        </h5>
        <div class="text-sm">
            <div v-for="state in states" :key="state.id" class="mt-2">
                <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({...query, state:state.slug, page: null}) }" class="small text-gray-800 hover:text-gray-600">{{state.name}}</NuxtLink>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['query', 'states'],
}
</script>