<template>
    <div>
        <h5 class="text-lg">
            Tipo de vendedor
        </h5>
        <div class="text-sm">
            <div class="mt-2">
                <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({...query, seller:'concesionaria', page: null}) }" class="small text-gray-800 hover:text-gray-600">Concesionaria</NuxtLink>
            </div>
            <div class="mt-2">
                <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({...query, seller:'particular', page: null}) }" class="small text-gray-800 hover:text-gray-600">Particular</NuxtLink>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['query'],
}
</script>