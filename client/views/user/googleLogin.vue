<template>
    
</template>
<script>
export default {
    mounted(){
        const token = this.$route.query.token
        // const redirectName = this.$route.query.redirectName
        const redirectName = 'user.dashboard'
        
        // console.log({token})
        this.$auth.loginWith('laravelJWT', { data: { token } })
        .then(res => {
            this.$router.push({name: redirectName})
        })
        .catch((err)=>{
            console.error(err)
            this.$router.push({name: redirectName})
        })
    }
}
</script>