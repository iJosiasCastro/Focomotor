<template>
    <div>
        <h5 class="text-lg">
            Precio
        </h5>
        <div class="text-gray-800 hover:text-gray-600 text-sm">
            <div class="mt-2" v-for="price in prices" :key="price.text">
                <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({...query, price_max: price.max, price_min:price.min , page:null})}" class="small text-gray-800 hover:text-gray-600">{{price.text}}</NuxtLink>
            </div>

            <div class="flex mt-3">
                <InputNumber v-model="price_min" id="priceMin" placeholder="mínimo"></InputNumber>
                <div class="mx-1 flex items-center">
                    <div class="w-1 border-t border-gray-600 mb-1"></div>
                </div>
                <InputNumber v-model="price_max" id="priceMax" placeholder="máximo"></InputNumber>
                <NuxtLink :to="{name:'vehicle.index', query: $store.getters.notEmpty({...query, price_max: this.price_max, price_min: this.price_min, page:null}) }" class="w-2/12 py-2 text-primary items-center flex justify-center hover:text-blue-500">
                    <span class="sr-only">Filtrar</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                </NuxtLink>
            </div>
        </div>
    </div> 
</template>

<script>
import InputNumber from './partials/inputNumber.vue'

export default {
    data() {
        return {
            price_min: "",
            price_max: "",
            prices: [
                { min: null, max: 500000, text: "Hasta $500.000" },
                { min: 500000, max: 1000000, text: "$500.000 a $1.000.000" },
                { min: 1000000, max: 5000000, text: "$1.000.000 a $5.000.000" },
                { min: 5000000, max: null, text: "Más de $5.000.000" },
            ]
        };
    },
    mounted() {
        if (this.value && this.type == "number") {
            var value = this.formatNumber(this.value.toLocaleString());
            document.getElementById(this.name).value = value;
        }
    },
    methods: {
        formatNumber(value) {
            value = value.replace(/[^0-9]+/g, "");
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return value;
        },
        handleInput(e) {
            var value = e.target.value;
            if (value && this.type == "number") {
                value = this.formatNumber(value);
                document.getElementById(this.name).value = value;
                this.$emit("input", parseInt(value.replace(/\./g, "")));
            }
            else {
                this.$emit("input", value);
            }
            this.$emit("clearError");
        }
        // applyPrice(){
        //     var filter = {}
        //     if(this.price_min){
        //         filter.price_min = this.price_min
        //     }
        //     if(this.price_max){
        //         filter.price_max = this.price_max
        //     }else{
        //         delete this.query.price_max
        //     }
        //     console.log(this.query)
        //     this.$router.push({query: {...this.query, ...filter}})
        // }
    },
    components: { InputNumber }
}
</script>