<template>
    <Header :isHeaderAuth="isHeaderAuth" :headerClass="headerClass">
        <Navbar />
    </Header>
</template>

<script setup>
import { ref } from 'vue';
import Header from '../common/Header.vue' 
import Navbar from '../common/header/Navbar.vue'

    const isHeaderAuth = ref(true)
    const headerClass = ref('bg-theme-transparent')
</script>

<style lang="scss">

</style>