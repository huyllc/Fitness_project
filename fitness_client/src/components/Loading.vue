<template>
    <div class="d-flex align-items-center">
        <div class="spinner-border me-2" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <span>{{ title }}</span>
    </div>
</template>

<script setup>
const props = defineProps({
    title: String,
})

</script>

<style scoped>
.align-items-center {
  align-items: center;
}
</style>
