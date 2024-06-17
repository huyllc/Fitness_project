<template>
    <button class="p-0 bg-transparent btn-seeall">
        <router-link :to="to" class="text-white text-decoration-none seeall-link d-block">See all</router-link>
    </button>
</template>

<script setup>
const props = defineProps({
    to: ''
})
</script>

<style lang="scss">

.btn-seeall{
    border: 0;
    outline: none;
    
    .seeall-link{        
        min-width: 185px;
        padding: 10px 0;
        background: url('@/assets/images/bg-button.svg') no-repeat center center / cover;
    }
}
</style>