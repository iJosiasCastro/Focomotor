<template>
    <section class="bg-gray-200 py-8 text-center">
        <div class="flex flex-col items-center justify-center">
            <h1 class="font-normal text-2xl">
                ¿Sos particular?
            </h1>
            <div class="mt-3">
                <img src="/img/partials/particular-300x154.png">
            </div>
            <p class="font-normal max-w-xs text-xl">Publicá en Focomotor tu vehículo <b>gratis</b>, <b>rápido </b>y <b>simple</b>.</p>
            <div class="mt-6 text-lg">
                <NuxtLink :to="{name: 'vehicle.create'}" class="bg-primary duration-500 hover:opacity-75 opacity-100 px-5 py-2 rounded-lg text-white transition-opacity">
                    Publicar gratis
                </NuxtLink> 
            </div>
        </div>
        <div class="relative flex py-12 items-center ">
            <div class="border-b border-gray-400 flex-grow max-w-4xl mx-auto"></div>
        </div>
        <div class="flex flex-col items-center justify-center">
            <h1 class="font-normal text-2xl">
                ¿Sos agencia o concesionaria?
            </h1>
            <div class="mt-3">
                <img src="/img/partials/concesionaria-768x207.png">
            </div>
            <p class="font-normal max-w-xs text-xl">
                ¡En Focomotor podés publicar <b>todos tus vehiculos</b>!
            </p>
            <div class="mt-6 text-lg">
                <NuxtLink :to="{name: 'plan.index'}" class="bg-primary duration-500 hover:opacity-75 opacity-100 px-5 py-2 rounded-lg text-white transition-opacity">
                    Ver planes
                </NuxtLink> 
            </div>
        </div>
    </section>
</template>