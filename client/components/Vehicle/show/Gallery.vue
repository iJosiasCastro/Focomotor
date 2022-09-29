<template>
<div>
    <client-only>
        <ssr-carousel show-arrows>
            <template>
                <div v-for="(image, i) in items" :key="i" @click="showPhotoSwipe(i)" class="slide bg-cover bg-center h-0 block w-full"
                   :style="{'background-image' : `url(${image.src})`}" style="padding-top: 70.37%">
                </div>
            </template>
            
            <template #back-arrow='{ disabled }'>
                <div v-show="!disabled" type="button" class="">
                    <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        <span class="hidden">Anterior</span>
                    </span>
                </div>
            </template>

            <template #next-arrow='{ disabled }'>
                <div v-show="!disabled" type="button" class="">
                    <span class="inline-flex justify-center items-center w-8 h-8 rounded-full sm:w-10 sm:h-10 bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-5 h-5 text-white sm:w-6 sm:h-6 dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        <span class="hidden">Siguiente</span>
                    </span>
                </div>
            </template>
        </ssr-carousel>

        <vue-picture-swipe class="viewer" :isOpen="isOpen" :items="items" :options="options" @close="hidePhotoSwipe"></vue-picture-swipe>

    </client-only>

    <noscript>
        <div class="overflow-hidden relative rounded-lg h-0 object-cover" style="padding-top: 70.37%">
            <div class="duration-200 ease-linear">
                <img :src="$store.state.large_url + images[0].name" class="object-cover h-full block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2">
            </div>

            <div v-for="(image, i) in images" :key="i" class="duration-200 ease-linear">
                <img v-show="i!=0" :src="$store.state.large_url + image.name" class="object-cover h-full block absolute top-1/2 left-1/2 w-full -translate-x-1/2 -translate-y-1/2">
            </div>
        </div>
    </noscript>

</div>
</template>

<script>
export default {
    name: 'carrousel',
    props: ['images'],
    async mounted(){
        var items = []
        // console.log(this.images)
        this.images.forEach(image => {
                items.push({
                w: 1024,
                h: 1024,
                src: this.$store.state.large_url + image.name,
            })
        })
        this.items = items
    },
    data() {
        return {
            isOpen: false,
            options: {
                index: 0,
                shareEl: false,
            },
            items: []
        }
    },
    methods: {
        showPhotoSwipe (index) {
            this.isOpen = true
            this.$set(this.options, 'index', index)
        },
        hidePhotoSwipe () {
            this.isOpen = false
        }
    },
}  
</script>

<style>
.pswp img {
    max-width: none;
    object-fit: contain;
}

.viewer {
    z-index: 30000;
    position: fixed;
}
</style>
