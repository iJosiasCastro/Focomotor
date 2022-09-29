<template>
<div>
    <div class="mb-10 mx-auto text-left">
        <label :for="name" class="block mb-1 text-lg text-gray-900" :class="{ 'text-red-700' : error}">
            {{label}}
        </label>
        <slot></slot>
        <div>
            <div class="flex">
                <slot name="preappend"></slot>
                <component :is="tag" :disabled="disabled" :rows="rows?rows:8"  @input="handleInput" :value="value" :type="type"
                :id="name" :placeholder="placeholder" :required="required"
                :class="error ? errorClasses + extraClasses : classes + extraClasses">{{value}}</component>
                <slot name="append"></slot>
            </div>
            
            <slot name="information"></slot>

            <p class="mt-2 text-red-600 dark:text-red-500 w-full" v-if="error">
                {{error}}
            </p>
        </div>

    </div>
</div>
</template>

<script>
export default {
    props: ['type', 'label', 'name', 'placeholder', 'required', 'value', 'errors', 'tag', 'extraClasses', 'rows', 'disabled'],
    data(){        
        return{
            classes: 'w-full block border py-2.5 px-4 rounded-lg text-lg flex-grow bg-gray-50 border-gray-400 focus:border-blue-500 focus:ring-blue-500 placeholder-gray-600 text-gray-900 ',
            errorClasses: 'w-full block border py-2.5 px-4 rounded-lg text-lg flex-grow bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 ',
        }
    },
    computed: {
        error(){
            if(this.errors && this.errors[this.name]){
                return this.errors[this.name][0]
            }

            return false
        },
    },
    methods: {
        handleInput (e) {
            var value = e.target.value
            if(value && this.type == 'number'){
                value = Number(value.replace(/[^0-9]+/g, ""))
                document.getElementById(this.name).value = value;
            }
            this.$emit('input', e.target.value)
            this.$emit('clearError')
        }
    }
}
</script>