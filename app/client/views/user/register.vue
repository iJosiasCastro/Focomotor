<template>
<App>
    <PartialsTitle background_num="10" title="Registrarse" />    
    <div class="max-w-xl mx-auto px-2">
        <div class="h-10 lg:h-16"></div>
        <div class="flex justify-center">
            <a :href="$axios.defaults.baseURL+'google-login'" class="bg-primary duration-500 hover:opacity-75 opacity-100 rounded-lg text-white transition-opacity flex">
            <div class="bg-gray-100 border-2 border-primary flex rounded-lg text-blue-600">
                <img class="h-8 my-auto mx-2" src="/img/partials/google-logo.png"/>
            </div>
            <div class="px-4 py-3">
                Registrarse con <span class="font-bold">Google</span>
            </div>
            </a>
        </div>
        <div class="h-12"></div>

        <UserForm redirectName="user.dashboard" />
        <div class="h-10 lg:h-16"></div>
    </div>
</App>
</template>

<script>
export default {
    head(){
        return {
            title: 'Crear cuenta - Focomotor'
        }
    },
}
</script>