<template>
<div class="border border-gray-400 bg-gray-100 duration-200 hover:-translate-y-1 hover:shadow-xl max-w-sm overflow-hidden rounded-lg shadow transform transition-all">

    <slot></slot>
    <ssr-carousel>
        <template>
            <NuxtLink :to="{ name:'vehicle.show', params:{slug:vehicle.slug} }" v-for="(image, i) in vehicle.images" :key="i" class="slide bg-cover bg-center h-0 block w-full"
                :style="{'background-image' : `url(${$store.state.thumbnail_url + image.name})`}" style="padding-top: 70.37%">
            </NuxtLink>
        </template>
    </ssr-carousel>
    <NuxtLink :to="{ name:'vehicle.show', params:{slug:vehicle.slug} }">
        <div class="px-3 py-4 text-gray-900">
            <div class="leading-tight mb-2 text-lg">{{vehicle.title}}</div>
            <span class="font-semibold text-lg md:text-xl">${{$store.getters.numFormater(vehicle.price)}}</span>
            <div class="font-semibold flex text-gray-700 text-sm mt-2">
                <span>
                    <i class="fas fa-map-marker-alt h-4"></i> 
                    {{vehicle.user.state.name}}, {{vehicle.user.district ? `${vehicle.user.district.name}, ` : ''}} {{vehicle.user.city.name}}
                </span>
            </div>
        </div>
    </NuxtLink>
</div>

    <!-- <div class="carousel slide">
                    <div class="carousel-inner">
                        <div class="carousel-item active" v-if="vehicle.images[indexCurrentImage]">
                            <img class="d-block w-100"
                                :src="vehicle.images[indexCurrentImage].name ?
                                $store.state.thumbnail_url + vehicle.images[indexCurrentImage].name :
                                'https://teja9.kuikr.com/images/car/default-cars.jpeg'">
                        </div>
                    </div>
                    <a class="carousel-control-prev" v-show="vehicle.images[indexCurrentImage-1] != null" @click="indexCurrentImage--">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next"  v-show="vehicle.images[indexCurrentImage+1] != null" @click="indexCurrentImage++">
                        <span class="carousel-control-next-icon"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div> -->
</template>

<script>
export default {
    props:['vehicle'],
    data(){
        return{
            indexCurrentImage:0,
        }
    }
    
}
</script>