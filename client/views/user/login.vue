<template>
<App>
  <PartialsTitle title="Ingresar" background_num="2" />
  <div class="max-w-xl mx-auto px-2">
    <div class="h-10 lg:h-16"></div>
    <UserLogin redirectName="user.dashboard" />
  </div>
</App>
</template>

<script>
export default {
  middleware: 'guest',
  head(){
        return {
            title: 'Ingresar - Focomotor'
        }
    },
}
</script>