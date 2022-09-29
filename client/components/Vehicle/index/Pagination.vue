<template>
    <!-- Pagination -->
    <nav class="col-span-2 md:col-span-3" v-if="vehicles.length">
        <ul class="flex flex-wrap items-center -space-x-px mt-8">
            <li v-for="(link,i) in page.links" :key="i" v-show="link.label.length<5" class="mb-5">
            <NuxtLink :to=" {name:'vehicle.index', query:{...query, page:link.label} } " class="py-1 px-2 text-gray-800 hover:text-gray-600 mx-3 border-t-4 mx-3 border-gray-400 hover:text-gray-600 hover:border-gray-300"
                :class="{ 'text-primary border-primary hover:text-blue-500 hover:border-blue-500' : link.active }">
                {{link.label}}
            </NuxtLink>
            </li>
        </ul>
    </nav>
    <div v-else>
        No se encontraron vehículos
    </div>
</template>

<script>
export default {
    props: ['vehicles', 'query', 'page'],
}
</script>