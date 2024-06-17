<template>
    <div>
        <div v-if="showFullText">
            {{ text }}
            <span v-if="text.length > maxLength" @click="toggleShow" class="btn-seemore">See less</span>
        </div>
        <div v-else>
            {{ textComputed }}
            <span  v-if="text.length > maxLength" @click="toggleShow" class="btn-seemore">See more</span>
        </div>
    </div>
</template>

<script setup>
import {ref, computed} from 'vue'
    const props = defineProps({
        text: {
            type: String,
            required: true
        },
        maxLength: {
            default: 80
        }
    });

    const showFullText = ref(false)
    const truncatedText = ref('')

    const toggleShow = () => {
        showFullText.value = !showFullText.value;
    }
    const textComputed = computed(() => truncatedText.value = props.text.length > props.maxLength 
                ? props.text.substring(0, props.maxLength) + '...' 
                : props.text);
</script>

<style>
.btn-seemore{
    cursor: pointer;
    color: #5932EA;
    font-weight: 600;
}
</style>