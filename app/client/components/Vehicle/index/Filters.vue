<template>
<div>
    <VehicleIndexFilterMobileMenu @openFilter="showFiltersModal = true" @openOrderBy="showOrderByModal = true" />
    <VehicleIndexFilterOrderByDropdown @closeOrderBy="showOrderByModal = false" :class="{'hidden' : !showOrderByModal}" v-click-outside="closeOrderByModal" :query="query" class="lg:hidden max-w-6xl mx-auto absolute left-0 ml-2 md:ml-4 mt-2 md:mt-48 w-56 bg-gray-200 border border-gray-400 border-solid divide-gray-100 divide-y rounded shadow z-10"  /> 
    
    <div class="h-5 lg:h-16"></div>
    <section class="gap-2 grid grid-cols-12 max-w-6xl mx-auto px-2 md:gap-4">
        <div class="col-span-3">

            <div id="filters" :class="{'hidden' : !showFiltersModal}" v-click-outside="closeFilterModal" class="absolute lg:static right-0 mr-2 -mt-3 lg:m-0 w-72 h-96 lg:w-full p-4 pb-8 bg-gray-200 border border-gray-400 border-solid overflow-y-scroll  rounded-lg shadow-lg z-10 md:overflow-auto lg:block lg:h-auto">
                <VehicleIndexActiveFilters :query="query" />
                <div class="h-2"></div>
                <h1 class="text-2xl">
                    Listado
                </h1>
                <div class="h-5"></div>
                <div class="hidden lg:block">
                    <VehicleIndexFilterOrderBy :query="query" @openOrderBy="showOrderByModal = true" />
                    <div class="h-6"> </div>
                    <VehicleIndexFilterOrderByDropdown @closeOrderBy="showOrderByModal = false" :class="{'hidden' : !showOrderByModal}" v-click-outside="closeOrderByModal" :query="query" class="max-w-6xl mx-auto absolute -mt-4"  /> 
                </div>
                <div v-if="!query.category">
                    <VehicleIndexFilterCategories :query="query" :categories="categories" />
                    <div class="h-6"></div>
                </div>
                <div v-if="brands.length && !query.brand">
                    <VehicleIndexFilterBrands :query="query" :brands="brands" />
                    <div class="h-6"></div>
                </div>
                <div v-if="models.length && !query.model">
                    <VehicleIndexFilterModels :query="query" :models="models" />
                    <div class="h-6"></div>
                </div>
                <VehicleIndexFilterPrice :query="query" />
                <div class="h-6"></div>
                <VehicleIndexFilterFuels :query="query" :fuels="fuels" />
                <div class="h-6"></div>
                <VehicleIndexFilterYear :query="query" />
                <div class="h-6"></div>
                <VehicleIndexFilterMileage :query="query" />
                <div class="h-6"></div>
                <VehicleIndexFilterCities :query="query" :cities="cities" />
                <div class="h-6"></div>

                


                
            </div>
            
        </div>
        <!-- Vehicles -->
        <div class="col-span-12 lg:col-span-9">
            <div class="gap-2 grid grid-cols-2 md:gap-4 md:grid-cols-3">
                <slot></slot>
            </div>

            <VehicleIndexPagination :vehicles="vehicles" :query="query" :page="page" />
            
        </div>
    </section>

    


</div>
</template>

<script>
export default {
    props: ['categories', 'brands', 'models', 'cities', 'fuels', 'page', 'query', 'vehicles'],
    data(){
        return {
            filters:{},
            showFiltersModal: false,
            openingFiltersModal: false,
            showOrderByModal: false,
            openingOrderByModal: false
        }
    },
    methods:{
        closeFilterModal(){
            if(this.openingFiltersModal){
                this.showFiltersModal=false
            }
        },
        closeOrderByModal(){
            if(this.openingOrderByModal){
                this.showOrderByModal=false
            }
        },
    },
    watch:{
        $route(){
            document.getElementById('filters').scrollTop = 0;
        },
        showFiltersModal(n,o){
            if(n&&!o){
                setTimeout(()=>{
                    this.openingFiltersModal=true
                },100)
            }else{
                this.openingFiltersModal=false
            }
        },
        showOrderByModal(n,o){
            if(n&&!o){
                setTimeout(()=>{
                    this.openingOrderByModal=true
                },100)
            }else{
                this.openingOrderByModal=false
            }
        },
    },
}
</script>
