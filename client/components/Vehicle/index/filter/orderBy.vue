<template>
    <div>
        <span class="mr-1">Ordenar por</span><br>
        <div class="text-gray-800 hover:text-gray-600 flex focus:outline-none items-center"> 
            <button @click="$emit('openOrderBy')" class="text-primary hover:text-blue-500 focus:outline-none">
                {{query.orderBy == 'price_asc' ? 'Menor precio' :  query.orderBy == 'price_desc' ? 'Mayor precio' : 'Mas recientes' }}
                <i class="fa-arrow-down fa-sm fas"></i> 
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props:['query'],
}
</script>