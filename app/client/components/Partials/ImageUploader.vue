<template>
    <div>
        <div class="form-group" @dragover.prevent="dragOver" @dragleave.prevent="dragLeave" @drop.prevent="submit($event)">

            <div :style="{'opacity' : dropped == 2 ? '50%' : '100%' }">

            <div class="w-full">
                <div class="flex justify-center items-center w-full">
                    <label class="flex flex-col justify-center items-center w-full h-48 bg-gray-50 rounded-lg border-4 border-gray-400 border-dashed cursor-pointer dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col justify-center items-center pt-5 pb-2">
                            <svg class="mb-3 w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            <p class="mb-2 text-sm text-gray-600 dark:text-gray-400"><span class="font-semibold">Subir imagenes </span></p>
                        </div>
                        <input type="file" class="opacity-0 h-2"
                            style="z-index: 1"
                            accept="image/png, image/jpeg"
                            ref="uploadInput"
                            @input="submit($event)"
                            multiple
                            :required="!files.length" />
                    </label>
                </div> 

                <!-- <div class="w-100 align-items-center border-info d-flex flex-column image-uploader justify-content-center m-1 pointer text-info"> 
                    <input
                        type="file"
                        style="z-index: 1"
                        accept="image/png, image/jpeg"
                        ref="uploadInput"
                        @input="submit($event)"
                        multiple
                        :required="!files.length"
                    />
                    <i class="fa-camera fa-lg fas"></i> 
                    <span class="small">Agregar fotos</span>
                </div> -->
            </div>

            <draggable class="flex flex-wrap grid grid-cols-2 sm:grid-cols-3" v-model="files">
                <div v-for="(file, i) in files" :key="i" class="items-center border border-gray-400 flex flex-col image-preview-div relative justify-center m-1 shadow text-red-600"> 
                    <div class="w-full bg-center bg-no-repeat bg-cover" style="padding-top: 70.37%" :style="{'background-image' : `url(${file.name ? $store.state.thumbnail_url + file.name : ObjectURL(file.image) })`}"></div>
                    <span class="isThumbnail absolute bottom-0 bg-white text-primary font-bold w-full text-center">Principal</span>
                    <div class="trash">
                        <i @click="deleteFile(i)" class="bg-white fa-sm fa-trash fas p-2 pointer rounded-full shadow"></i>
                    </div>
                </div>
            </draggable>
            </div>      

        </div>

        <p class="mt-2 text-red-600 dark:text-red-500" v-if="error">
            {{error}}
        </p>

    </div>
</template>

<script>
import draggable from 'vuedraggable'
import imageCompression from 'browser-image-compression'

export default {
    props:['editable'],
    components:{
        draggable
    },
    created(){
        if(this.editable){
            this.editable.forEach(e => {
                this.files.push(e)
            })
        }
    },
    data() {
        return {
            inputFiles: null,
            files: [],
            dropped: 0,
            error: '',
            maxError: 'Se pueden subir hasta 5 imagenes',
            fileError: 'Solo se pueden subir imagenes',  
            max: 5,
            options: {
                maxSizeMB: .5,
                maxWidthOrHeight: 1024,
                useWebWorker: true
            }
        }
    },  
    watch:{
        files(){
            const f = this.files
            this.$emit('input', this.files.map(v=>{
                return {
                    image: v.base64,
                    name: v.name,
                }
            }))
        }
    },
    methods: {
        dragOver() {
        this.dropped = 2
        },
        dragLeave() {
        this.dropped = 0
        },
        submit(e) {

            let files = []
            e.type=='drop' ?
                files = Array.from(e.dataTransfer.files) :
                files = Array.from(e.target.files)

            if (e && files) {
                files.forEach(async (file) => {
                    if (file.type.startsWith("image") == true){
                        if (this.max && files.length + this.files.length > this.max){
                            this.error = this.maxError
                        }else{
                            this.error = ''
                            if(typeof file != 'string'){
                                const image = await imageCompression(file, this.options)
                                const base64 = await this.getBase64(image);
                                // console.log(base64)
                                this.files.push({image, base64, id: Math.floor(Math.random()*100)})
                            }
                        }
                    } else {
                        this.error = this.fileError
                    }
                })
            }
            this.$emit("changed", this.files)
            this.dropped = 0
        },
        getBase64(file) {
            return new Promise((resolve, reject)=>{
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    resolve(reader.result);
                };
                reader.onerror = function (error) {
                    // console.log('Error: ', error);
                };
            })
        },
        append() {
            this.$refs.uploadInput.click()
        },
        deleteFile(index) {
            const file = this.files.splice(index, 1)[0]
            this.$refs.uploadInput.value = null
        },
        ObjectURL(image){
            return URL.createObjectURL(image)
        },
    },
}
</script>

<style scoped>
.isThumbnail{
  display: none;
  cursor: move;
}

.image-preview-div:first-of-type .isThumbnail{
  display: block !important;
}


input:hover {
    cursor: pointer;
}

.image-uploader:hover {
    opacity: 60%;
}

.trash {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}



</style>