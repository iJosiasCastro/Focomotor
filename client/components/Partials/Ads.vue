<template>
<div>
    <ssr-carousel class="mx-auto max-w-xl" :loop="true" :autoplayDelay="4">
        <template>
            <div v-for="(ad, i) in ads" :key="i" class="slide w-100" ref="gallery">
                <img :src="`./img/ads/${ad}.png`" :alt="ad">
            </div>
        </template>
    </ssr-carousel>
</div>
</template>

<script>
export default {
    props:['ads'],
}
</script>