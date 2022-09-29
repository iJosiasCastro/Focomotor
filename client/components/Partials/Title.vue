<template>
    <div :style="{'background-image':'linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.7)),' + `url('/img/headers/header-${background_num}.jpg')`}"
        class="bg-black bg-center text-center bg-cover flex h-32 md:h-48 items-center justify-center text-3xl md:text-4xl text-white">
        <h1>{{title}}</h1>
    </div>
</template>

<script>
export default {
    props:['background_num', 'title']
}
</script>