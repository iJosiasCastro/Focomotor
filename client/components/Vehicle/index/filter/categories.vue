<template>
    <div>
        <h5 class="text-lg">
            Categoria
        </h5>
        <div class="text-sm">
            <div v-for="category in categories" :key="category.id" class="mt-2">
                <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({...query, category:category.slug, page: null}) }" class="small text-gray-800 hover:text-gray-600">{{category.name}}</NuxtLink>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['query', 'categories'],
}
</script>