<template>
    <MainLayout>
        <div class="app-container">
            <List v-if="courses.length > 0" :page="page" :courses="courses" :pagination="pagination"/>
            <h1 v-if="!loading && courses.length <= 0" class="text-center">
                Chưa có khoá học nào
            </h1>
            <div class="text-center" v-if="loading">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
	</MainLayout>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import MainLayout from '../layout/MainLayout.vue'
import List from './List/List.vue'
import { useRoute } from 'vue-router';
import axios from 'axios';
    const route = useRoute()
    const courses = ref([])
    const pagination = ref({})
    const loading = ref(false)
       
    watch(route, () => getCourses())
    onMounted (() => getCourses())
    const getCourses = async() => {
        const page = route.query.page
        loading.value = true;

        try {
            const response = await axios.get(`course/review?page=${page}`, {params: {limit: 9}});

            if (response.data) {
                courses.value = response.data.data;
                pagination.value = response.data.meta;
                loading.value = false;
            }
        } catch (err) {
            console.log(err.response);
        }
    }
</script>