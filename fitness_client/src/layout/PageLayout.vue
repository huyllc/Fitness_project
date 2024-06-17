<template>
    <div class="page-wrapper d-flex flex-column min-vh-100" :class="pageClass">
        <slot />
    </div>
</template>

<script setup>
    const props = defineProps({
        pageClass: {
            type: String,
            default: ''
        }
    })
</script>
