<template>
    <form @submit.prevent="search">
        <input
            type="text"
            name="search"
            class="col-3 form-control w-auto flex-grow-1"
            :class="searchClass"
            placeholder="search"
            v-model="query"
        />
    </form>
</template>

<script setup>
    import { ref } from 'vue'
    const props = defineProps({
        searchClass: {
            type: String,
            default: ''
        },
    });
    const emit = defineEmits([
        'search'
    ])
    const query = ref('')
    const search = () => {
        emit('search', query.value);
    }
</script>