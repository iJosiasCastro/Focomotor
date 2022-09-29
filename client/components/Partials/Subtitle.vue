<template>
    <div class="border-primary border-t-8 rounded-t-lg">
        <div class="bg-gray-100 border-b border-gray-400 border-l border-r border-solid py-5 rounded-b-lg shadow-lg">
            <h3 class="text-2xl px-8 leading-10">{{subtitle}}</h3>
        </div>
    </div>
</template>

<script>
export default {
    props:['subtitle']
}
</script>