<template>
    <div class="row">
        <div class="col-10">
            <h3>{{ title }}</h3>
        </div>
        <div class="col-2">
            <form @submit.prevent="search">
                <input
                    type="text"
                    name="search"
                    class="col-3 form-control"
                    placeholder="search"
                    v-model="searchValue"
                />
            </form>
        </div>
    </div>
</template>

<script setup>
    import { ref, defineEmits, defineProps } from "vue";

    const props = defineProps({
        title: {
            type: String,
            required: true,
        },
    });

    const searchValue = ref("");
    const emit = defineEmits(['search']);

    const search = () => {
        emit('search', searchValue.value);
    };
</script>
