<template>
    <div class="d-flex gap-4 align-items-center p-3 mb-5 block-total shadow-lg">
        <img src="@/assets/images/user_logo.svg" alt="">
        <div class="d-flex flex-column gap-2">
            <p class="mb-0 fs-4 ">{{ title }}</p>
            <p class="mb-0 fs-3 fw-bold">{{ count }}</p>
        </div>
    </div>
</template>

<script setup>
    const props = defineProps({
        title: 'Total',
        count: 0
    });
</script>

<style lang="scss">
.block-total{
    border-radius: 15px;
    box-shadow: 0px 10px 10px rgba(0,0,0,0.15);
}
</style>