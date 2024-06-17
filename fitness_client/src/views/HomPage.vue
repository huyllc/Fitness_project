<template>
    <MainLayout :headerClass="headerClass" :pageClass="'page-home'">
        <Banner />
        <Courses :courses="popularCourses"/>
	</MainLayout>
</template>

<script setup>
import MainLayout from '../layout/MainLayout.vue'
import Banner from './home/Banner.vue'
import Courses from './home/Courses.vue'
import {onMounted, ref} from 'vue'
import axios from 'axios'
    const headerClass = ref('bg-theme-transparent')
    const popularCourses = ref([])
    onMounted (() => getPopularCourses())
    const getPopularCourses = async () => {
        try {
            const response = await axios.get('/course/popular');

            popularCourses.value = response.data.data;
        } catch (err) {
            throw new Error('error', err);
        }
    }
</script>
