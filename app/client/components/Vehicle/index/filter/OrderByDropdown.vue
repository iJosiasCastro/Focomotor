<template>
    <div class="w-56 bg-gray-200 border border-gray-400 border-solid divide-gray-100 divide-y rounded shadow z-10">
        <ul class="py-1 text-gray-700 dark:text-gray-200">
            <li @click="$emit('closeOrderBy')">
            <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({...query, orderBy:'date', page:null}) }" class="block hover:bg-gray-100 px-4 py-2" :class=" {'text-primary' : query.orderBy != 'price_asc' && query.orderBy != 'price_desc'} ">Mas recientes</NuxtLink>
            </li>
            <li @click="$emit('closeOrderBy')">
            <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({...query, orderBy:'price_asc', page:null}) }" class="block hover:bg-gray-100 px-4 py-2" :class=" {'text-primary' : query.orderBy == 'price_asc'} ">Menor precio</NuxtLink>
            </li>
            <li @click="$emit('closeOrderBy')">
            <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({...query, orderBy:'price_desc', page:null}) }" class="block hover:bg-gray-100 px-4 py-2" :class=" {'text-primary' : query.orderBy == 'price_desc'} ">Mayor precio</NuxtLink>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props:['query']
}
</script>