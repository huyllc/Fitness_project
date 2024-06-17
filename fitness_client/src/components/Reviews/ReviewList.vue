<template>
    <div class="d-flex flex-column gap-4">
        <ReviewItem v-for="review in reviews" :key="review.id" :review="review"/>
    </div>
    <div class="d-flex justify-content-center align-items-center mt-4 gap-3">
        <button v-if="!hideButton" class="p-0 bg-transparent btn-seemore" @click="loadMore">
            <div class="text-white fw-medium btn-wrap">           
                <span v-if="loading" class="seemore-spin" role="status">
                </span>
                <span v-else>See more</span>
            </div>
        </button>
        <button type="button" class="p-0 bg-transparent btn-create-review" data-bs-toggle="modal" data-bs-target="#modal-review">
            <span class="text-white">
                Create Review
            </span>
        </button>
    </div>
</template>

<script setup>
import ReviewItem from './ReviewItem.vue';
import { defineEmits, defineProps } from 'vue';
    const emits = defineEmits([
        'load-more'
    ])
    const props = defineProps({
        reviews: [],
        loading: false,
        hideButton: false 
    })
    const loadMore = () => {
        emits('load-more');
    }
</script>

<style lang="scss">
.btn-seemore, .btn-create-review{
    border: 0;
    outline: none;
    
    >span, .btn-wrap{       
        display: inline-block; 
        min-width: 185px;
        padding: 10px 0;
        background: url('@/assets/images/bg-button.svg') no-repeat center center / cover;
        position: relative;
        min-height: 40px;
    }
}

.seemore-spin{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 30px;
    height: 30px;
    display: inline-block;
    border-radius: 50%;
    border: 4px solid #FFF;
    border-right-color: transparent;
    animation: .75s linear infinite spinner-seemore;
}

@keyframes spinner-seemore {
    100% {
        transform: translate(-50%, -50%) rotate(360deg);
    }
}
</style>