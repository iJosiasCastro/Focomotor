<template>
<div>
    <div class="flex flex-col items-center justify-center">
        <h1 class="font-normal text-2xl text-center">
            <svg class="inline flex-shrink-0 w-6 h-6 my-auto mb-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>

            Ya alcanzaste el máximo de publicaciones gratis.
        </h1>
        <div class="h-6"></div>
        <div class="font-normal max-w-md text-lg text-center">
            <p>
                Para seguir publicando te invitamos a elegir uno de nuestros planes:
            </p>
        </div>
        <div class="mt-6 text-lg">
            <NuxtLink :to="{name: 'plan.index'}" class="bg-primary duration-500 hover:opacity-75 opacity-100 px-5 py-2 rounded-lg text-white transition-opacity">
                Ver planes
            </NuxtLink> 
        </div>
    </div>
</div>
</template>