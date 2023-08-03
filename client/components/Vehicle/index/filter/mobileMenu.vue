<template>
    <div class="border-b border-gray-400 flex h-10 shadow-sm text-primary lg:hidden">
        <!-- Order By -->
        <div class="flex items-center justify-around w-1/2">
            <button @click="$emit('openOrderBy')" class="flex items-center px-8"> 
                <span class="mr-2">Ordenar</span> 
                <i class="fa-arrow-down fa-sm fas"></i> 
            </button>
        </div>
        <div class="border-gray-500 border-r my-2"></div>
        <!-- Filters button -->
        <div class="flex items-center justify-around w-1/2">
            <button @click="$emit('openFilter')" class="flex items-center px-8">
            <span class="mr-2">Filtros</span>
            <i class="fa-filter fa-xs fas"></i>
            </button>
        </div>
    </div>
</template>