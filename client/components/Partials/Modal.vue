<template>
<div>
    <div v-show="show" class="overflow-y-auto flex overflow-x-hidden fixed top-0 right-0 left-0 z-50 inset-0 h-modal h-full bg-black bg-opacity-50">
        <div v-click-outside="close" class="relative mx-auto my-auto p-4 w-full max-w-md my-auto">
            <div class="relative bg-white rounded-lg shadow">
                <button @click="close" type="button" class="absolute top-3 right-2.5 text-gray-600 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                </button>
                <div class="p-6 text-center">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script>
export default {
    props:['show'],
    data(){
        return{
            opening: false,
        }
    },
    watch:{
        show(n,o){
            if(n&&!o){
                setTimeout(()=>{
                    this.opening=true
                },100)
            }else{
                this.opening=false
            }
        }
    },
    methods:{
        close(){
            if(this.opening){
                this.$emit('close')
                this.send = false
            }
        },
    }
}
</script>