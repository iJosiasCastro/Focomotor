<template>
    <input
        type="text"
        :id="id"
        class="w-5/12 h-10 border py-2.5 px-2 rounded-lg text-sm flex-grow bg-gray-50 border-gray-400 focus:border-blue-500 focus:ring-blue-500 placeholder-gray-600 text-gray-900"
        :placeholder="placeholder"
        @input="handleInput"
    >
</template>

<script>
export default {
    props: {
        placeholder: {
            type: String
        },
        id: {
            type: String
        },
        value: {
            type: String
        },
        format: {
            type: Boolean,
            default: true
        }
    },
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
        if (this.value) {
            var value = this.formatNumber(this.value.toLocaleString());
            document.getElementById(this.id).value = value;
        }
    },
    methods: {
        formatNumber(value) {
            value = value.replace(/[^0-9]+/g, "");
            console.log(this.format)
            if(this.format){
                value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
            return value;
        },
        handleInput(e) {
            console.log('test')
            var value = e.target.value;
            console.log(value)
            if (value) {
                value = this.formatNumber(value);
                document.getElementById(this.id).value = value;
                this.$emit("input", parseInt(value.replace(/\./g, "")));
            }
            else {
                this.$emit("input", value);
            }
            this.$emit("clearError");
        }
    }
}
</script>