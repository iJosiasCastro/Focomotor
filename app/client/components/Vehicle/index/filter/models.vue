<template>
    <div>
        <h5 class="text-lg">
            Modelos
        </h5>
        <div class="text-sm">
            <div v-for="model in models" :key="model.id" class="mt-2">
                <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({...query, model:model.slug, page: null}) }" class="small text-gray-800 hover:text-gray-600">{{model.name}}</NuxtLink>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['query', 'models'],
}
</script>