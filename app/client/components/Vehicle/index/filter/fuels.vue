<template>
    <div>
        <h5 class="text-lg">
            Combustible
        </h5>
        <div class="text-sm">
            <div v-for="fuel in fuels" :key="fuel.id" class="mt-2">
                <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({...query, fuel:fuel.slug, page: null}) }" class="small text-gray-800 hover:text-gray-600">{{fuel.name}}</NuxtLink>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['query', 'fuels']
}
</script>