<template>
<App>
    <div class="h-5 md:h-10"></div>
    <section class="max-w-3xl mx-auto px-2 lg:max-w-5xl">

        <div class="gap-4 grid grid-cols-12">
            <div class="col-span-12 md:col-span-8">
                <VehicleShowGallery :images="data.vehicle.images" />
            </div>
            <div class="col-span-12 md:col-span-4 max-h-0">
                <div class="md:bg-gray-200 md:border md:border-gray-400 md:border-solid md:p-4 md:rounded-lg md:shadow-lg">
                    <h1 class="text-xl md:text-2xl">{{data.vehicle.title}}</h1>
                        
                    <p class="text-sm text-gray-700">Publicado {{formatDate(data.vehicle.created_at) }}</p>
                    <div class="h-3"></div>
                    <div class="flex">
                        <div class="bg-primary px-3 py-2 rounded-lg text-white transition-opacity font-bold">
                            {{data.vehicle.category.name}}
                        </div>
                    </div>
                    <div class="h-2"></div>
                    <div>
                        <div class="text-gray-800 text-sm">
                            <div class="mt-5">
                                <span class="text-gray-700">Precio</span>
                                <h5 class="font-bold text-2xl">${{$store.getters.numFormater(data.vehicle.price)}}</h5>
                            </div>
                        </div>
                        <div class="text-gray-700 text-sm">
                            <div class="mt-5">
                                <span class="text-gray-700">Ubicación</span>
                                <h5 class="flex font-bold text-lg"> <i class="fa-map-marker-alt fas h-4 mt-1 mr-1"></i>
                                    <span>{{data.vehicle.user.state.name}}, {{data.vehicle.user.district ? `${data.vehicle.user.district.name}, ` : ''}} {{data.vehicle.user.city.name}}</span>
                                </h5>
                            </div>
                            <div class="mt-2"></div>
                        </div>
                    </div>
                </div>
                <div class="h-5"></div>
                <div class="bg-gray-200 border border-gray-400 border-solid rounded-lg shadow-lg text-center">
                    <div class="p-4">
                        <h3 class="text-xl">Datos del vendedor</h3>
                        <div class="h-5"></div>
                        <div class="flex-col inline-flex">
                            <div class="-mb-2 inline-flex items-center">
                                <i class="fa-user-circle fas h-5 mb-3 text-primary text-3xl mr-1"></i>
                                <h4 class="text-xl">{{data.vehicle.user.name}}</h4>
                            </div>
                            <p class="text-gray-800 mt-2">{{data.vehicle.user.role_id == 1 ? 'Particular' : 'Concesionaria'}}</p>
                        </div>
                        <div class="h-5"></div>

                        <div class="flex justify-center">
                            <button @click="showMessageModal=true" class="flex bg-primary duration-500 hover:opacity-75 opacity-100 px-3 py-2 rounded-lg text-lg text-white transition-opacity">
                                <i class="fa-envelope far mr-2 h-5 my-auto"></i>
                                Enviar mensaje 
                            </button>
                            <VehicleShowMessageModal :show="showMessageModal" @close="showMessageModal=false" :vehicleSlug="data.vehicle.slug" />
                        </div>

                        <template v-if="data.vehicle.user.whatsapp">
                            <div class="h-2"></div>
                            <div class="flex justify-center">
                                <a :href="`https://api.whatsapp.com/send?phone=54${data.vehicle.user.whatsapp}&text=Hola.%20%C2%BFSigue%20disponible%3F%0Ahttps%3A%2F%2Ffocomotor.com.ar%2Fvehiculos%2F${data.vehicle.slug}`"
                                
                                style="background-color: #21b558" class="flex duration-500  hover:opacity-75 opacity-100 px-3 py-2 rounded-lg text-lg text-white transition-opacity">
                                    <i class="fa-whatsapp fab mr-1 my-auto"></i>
                                    Whatsapp 
                                </a>
                            </div>
                        </template>

                        <template v-if="data.vehicle.user.phone">
                            <div class="h-2"></div>
                            <div class="flex justify-center">
                                <button @click="showTelModal=true" class="bg-gray-700 flex duration-500  hover:opacity-75 opacity-100 px-3 py-2 rounded-lg text-lg text-white transition-opacity">
                                    <i class="fa-phone-alt fas mr-1 my-auto"></i>
                                    Telefono 
                                </button>
                                <PartialsModal :show="showTelModal" @close="showTelModal=false">
                                    <div class="my-5 text-center ">
                                        <div class="mb-4">
                                            <h4 class="text-xl font-normal text-gray-800">Teléfono</h4>
                                        </div>
                                        <div class="flex">
                                            <a :href="'tel:'+data.vehicle.user.phone" class="mx-auto bg-primary flex duration-500  hover:opacity-75 opacity-100 px-3 py-2 rounded-lg text-2xl text-white transition-opacity">
                                                <i class="fa-phone-alt fas mr-2 my-auto"></i>
                                                {{data.vehicle.user.phone}} 
                                            </a>
                                        </div>
                                    </div>
                                </PartialsModal>
                            </div>
                        </template>

                        <div class="h-3"></div>
                    </div>
                    <div class="w-100">
                        <div class="border-gray-500 border-solid border-t py-2">
                            <NuxtLink :to="{name: 'vehicle.author', params: {slug:data.vehicle.user.slug} }" class="font-bold">
                                <p class="text-primary">
                                    Más vehiculos de este vendedor
                                </p>
                            </NuxtLink>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 md:col-span-8">
                <h2 class="font-normal text-xl mb-3">Especificaciones:</h2>
                <div class="gap-2 grid grid-cols-2 md:gap-4 md:grid-cols-3 lg:col-span-4">
                    <div>
                        <span class="text-gray-700">Marca</span>
                        <h5 class="text-xl">{{data.vehicle.brand ? data.vehicle.brand.name : 'Otro'}}</h5>
                    </div>
                    <div>
                        <span class="text-gray-700">Modelo</span>
                        <h5 class="text-xl">{{data.vehicle.model ? data.vehicle.model.name : 'Otro'}}</h5>
                    </div>
                    <div>
                        <span class="text-gray-700  ">Año</span>
                        <h5 class="text-xl">{{data.vehicle.year}}</h5>
                    </div>
                    <div>
                        <span class="text-gray-700">Kilometraje</span>
                        <h5 class="text-xl">{{$store.getters.numFormater(data.vehicle.mileage)}}km</h5>
                    </div>
                    <div>
                        <span class="text-gray-700">Combustible</span>
                        <h5 class="text-xl">{{data.vehicle.fuel ? data.vehicle.fuel.name : 'Otro'}}</h5>
                    </div>
                </div>
                <div class="h-12"></div>
                
                <div v-if="data.vehicle.description">
                    <h2 class="font-normal text-xl mb-3">Descripción:</h2>
                    <div class="text-lg">
                        <p>{{data.vehicle.description}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div></div>
        <!-- Vehículo (Actualizado) -->
        <div class="h-10 lg:h-16"></div>

        <ins class="adsbygoogle"
            style="display:block"
            data-ad-client="ca-pub-5902667990414861"
            data-ad-slot="7655064208"
            data-ad-format="auto"
            data-full-width-responsive="true"></ins>


        <div class="h-24"></div>
        <h1 class="font-normal text-2xl">Te puede interesar:</h1>
        <div class="gap-2 grid grid-cols-2 mt-3 md:gap-4 md:grid-cols-3">
            <VehicleCard
                v-for="vehicle in data.related"
                :key="vehicle.id"
                :vehicle="vehicle"
            />
        </div>
    </section>
    
</App>
</template>

<script>
import moment from 'moment'
import 'moment/locale/es'
moment.locale('es')

export default {
    head(){
        return {
            title: this.data.vehicle.title + ' - Focomotor',
            scripts: [
                { hid: 'adsense', src: 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js', defer: true, 'data-ad-client': 'ca-pub-5902667990414861' },
            ]
        }
    },
    mounted(){
        this.$nextTick(() => {
        try {
            // this is required for each ad slot (calling this once will only load 1 ad)
            (window.adsbygoogle = window.adsbygoogle || []).push({})
        } catch (error) {
            console.error(error)
        }
        })
    },
    async asyncData({ $axios, params, error }) {
        return await $axios.$get("vehicle/" + params.slug + "?related=true")
            .then((res) => {
                return { data: res };
            })
            .catch(() => error({ status: 404 }));
    },
    methods: {
        formatDate(date) {
        return moment(date).fromNow()
        }
    },
    data() {
        return {
            showMessageModal: false,
            showTelModal: false
        };
    },
};
</script>