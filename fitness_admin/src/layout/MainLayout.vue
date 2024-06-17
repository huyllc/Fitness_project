<template>
    <div class="page-wrapper">
        <div class="row">
            <div class="col-2">
                <Sidebar />
            </div>
            <div class="col-10">
                <Header />
                <main class="page-main">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>

<script setup>
import Sidebar from '@/components/Sidebar.vue';
import Header from '@/components/Header.vue';

</script>

<style lang="scss">
.page-main{
    padding: 20px;
}
</style>

