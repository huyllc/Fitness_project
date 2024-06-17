<template>
    <div class="row g-5">
        <div class="col-4" v-for="course in courses" v-if="courses !== undefined && courses.length > 0">
            <CourseReview :course="course" :key="course.id"/>
        </div>
        <Pagination 
            :pagination="pagination" 
            :to="'courses'"
        />
    </div>
</template>

<script setup>
import CourseReview from '@/components/Course/CourseReview.vue';
import Pagination from '@/components/Pagination.vue';
import { defineProps } from 'vue';
const props = defineProps({
    courses: [],
    pagination: {}
    
})
</script>
