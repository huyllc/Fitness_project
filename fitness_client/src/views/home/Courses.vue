<template>
    <div class="block-courses py-5" v-if="courses !== undefined && courses.length > 0">
        <div class="app-container">
            <h2 class="text-center mb-5 text-white">Our Popular Courses</h2>
            <div class="row g-5 mb-5">
                <div class="col-4" v-for="course in courses">
                    <CourseReview :course="course" :key="course.id" :isLight="true"/>
                </div>
            </div>
            <div class="d-block text-center">
                <ButtonSeeall :to="'courses'"/>
            </div>
        </div>
    </div>
</template>

<script setup>
import ButtonSeeall from '@/components/ButtonSeeall.vue';
import CourseReview from '@/components/Course/CourseReview.vue';
import { defineProps } from 'vue';
    const props = defineProps({
        courses: []    
    })
</script>

<style lang="scss">
.block-courses{
    background: #000;
}
</style>