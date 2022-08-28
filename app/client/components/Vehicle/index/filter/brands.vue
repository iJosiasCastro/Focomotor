<template>
    <div>
        <h5 class="text-lg">
            Marcas
        </h5>
        <div class="text-sm">
            <div v-for="brand in brands" :key="brand.id" class="mt-2">
                <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({...query, brand:brand.slug, page: null}) }" class="small text-gray-800 hover:text-gray-600">{{brand.name}}</NuxtLink>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['query', 'brands'],
}
</script>