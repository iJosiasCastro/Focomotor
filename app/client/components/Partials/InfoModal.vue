<template>
<div>
    <PartialsModal :show="show" @close="$emit('close')">
        <div class="p-6 text-center">
            <div class="h-5"></div>
            <div class="mb-4">
            <NuxtLink :to="{name:'info.terms'}" class="text-lg font-normal text-gray-800">Terminos y Condiciones</NuxtLink>
            </div>
            <div class="mb-4">
            <NuxtLink :to="{name:'info.policy'}" class="text-lg font-normal text-gray-800">Política de privacidad</NuxtLink>
            </div>
            <div class="">
            <NuxtLink :to="{name:'info.contact'}" class="text-lg font-normal text-gray-800">Contacto</NuxtLink>
            </div>
            <div class="h-5"></div>
        </div>
    </PartialsModal>
</div>

</template>

<script>
export default {
    props:['show'],
}
</script>