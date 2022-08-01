<template>
<App>
    <PartialsTitle background_num="2" title="Editar información de usuario" />    
    <div class="max-w-xl mx-auto px-2">
        <div class="h-10 lg:h-16"></div>
        <UserForm redirectName="user.dashboard" :editable="user" />    
        <div class="h-10 lg:h-16"></div>

    </div>
</App>
</template>


<script>
export default {
    middleware: 'auth',
    head(){
        return {
            title: 'Editar cuenta - Focomotor'
        }
    },
    async asyncData({$axios}){
        const user = await $axios.$get('auth/user')
        // console.log(user)
        return {user}
    },
}
</script>